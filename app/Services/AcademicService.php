<?php

namespace App\Services;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Exception;

class AcademicService
{
    /**
     * Handle the transition of the academic year.
     *
     * @param array $promotionMapping  Array mapping 'Old Class Name' => 'New Class Name'
     *                                e.g. ['10 TKJ 1' => '11 TKJ 1', '10 TKJ 2' => '11 TKJ 2']
     * @param array $graduatingClasses Array of Class Names that are graduating
     *                                e.g. ['12 TKJ 1', '12 TKJ 2']
     * @return array Result summary
     * @throws Exception
     */
    public function transisiTahunAjaran(array $promotionMapping, array $graduatingClasses)
    {
        return DB::transaction(function () use ($promotionMapping, $graduatingClasses) {
            $graduatedCount = 0;
            $promotedCount = 0;
            $errors = [];

            // 1. Handle Graduation (Data Lulus)
            // Students in these classes will have their kelas_id set to null (or we could move them to 'Alumni' if such logic existed)
            // Ideally validation that these classes exist should be done before, but we handle graceful failure here.

            if (!empty($graduatingClasses)) {
                $kelasLulusIds = Kelas::whereIn('nama_kelas', $graduatingClasses)->pluck('id');

                if ($kelasLulusIds->isNotEmpty()) {
                    $graduatedCount = Siswa::whereIn('kelas_id', $kelasLulusIds)->update(['kelas_id' => null]);
                }
            }

            // 2. Handle Promotion (Kenaikan Kelas)
            // We must be careful about the order. 
            // If we promote 10 -> 11, and we also have logic for 11 -> 12.
            // If we run 10->11 first, those students become 11. Then if we run 11->12, they become 12.
            // So we effectively moved 10->12 in one go. That is WRONG.

            // Strategy: 
            // A. Fetch all students to be promoted first, keyed by their current class.
            // B. Perform updates based on specific student IDs.

            // Let's build a plan of "Student ID X moves to Class ID Y".
            $promotionPlan = []; // [siswa_id => new_kelas_id]

            foreach ($promotionMapping as $oldAdaKelas => $newAdaKelas) {
                $oldClass = Kelas::where('nama_kelas', $oldAdaKelas)->first();
                $newClass = Kelas::where('nama_kelas', $newAdaKelas)->first();

                if (!$oldClass) {
                    $errors[] = "Kelas asal '$oldAdaKelas' tidak ditemukan.";
                    continue;
                }
                if (!$newClass) {
                    $errors[] = "Kelas tujuan '$newAdaKelas' tidak ditemukan.";
                    continue;
                }

                // Get students currently in old class
                // We lock for update to ensure consistency if needed, though usually excessive for this.
                $studentIds = Siswa::where('kelas_id', $oldClass->id)->pluck('id');

                foreach ($studentIds as $sid) {
                    $promotionPlan[$sid] = $newClass->id;
                }
            }

            // Execute Promotion Updates
            // Optimizing: We can group by target class to reduce queries
            // [new_kelas_id => [array of student ids]]
            $updatesByTarget = [];
            foreach ($promotionPlan as $sid => $tid) {
                $updatesByTarget[$tid][] = $sid;
            }

            foreach ($updatesByTarget as $targetClassId => $sids) {
                $promotedCount += Siswa::whereIn('id', $sids)->update(['kelas_id' => $targetClassId]);
            }

            return [
                'status' => 'success',
                'graduated_count' => $graduatedCount,
                'promoted_count' => $promotedCount,
                'errors' => $errors
            ];
        });
    }

    /**
     * Promote selected students to a target class.
     *
     * @param array $studentIds Array of student IDs
     * @param int|null $targetClassId Target Class ID. If null, students qualify as graduated/removed from class.
     * @return int Number of rows updated
     */
    public function promoteStudents(array $studentIds, ?int $targetClassId)
    {
        return DB::transaction(function () use ($studentIds, $targetClassId) {

            // If targetClassId is NOT null => Promotion
            if ($targetClassId !== null) {
                return Siswa::whereIn('id', $studentIds)->update([
                    'kelas_id' => $targetClassId,
                    'status' => 'aktif', // Reset status if they were effectively alumni re-joining? Unlikely but safe.
                    'tahun_lulus' => null,
                ]);
            }

            // If targetClassId IS null => Graduation (Alumni)
            else {
                // We need to record 'kelas_terakhir' for each student. 
                // Since update() is bulk, we can't easily record individual current class unless we query first.
                // Optimally:
                $students = Siswa::whereIn('id', $studentIds)->with('kelas')->get();
                $count = 0;
                $currentYear = date('Y');

                foreach ($students as $siswa) {
                    $className = $siswa->kelas ? $siswa->kelas->nama_kelas : null;

                    $siswa->update([
                        'kelas_id' => null,
                        'status' => 'alumni',
                        'kelas_terakhir' => $className,
                        'tahun_lulus' => $currentYear
                    ]);
                    $count++;
                }
                return $count;
            }
        });
    }
}
