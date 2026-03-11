<?php
class PatientRepository {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getRecentAdmissions(int $limit = 5): array {
        $stmt = $this->db->prepare("SELECT id, name, age, gender, status FROM children ORDER BY id DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDashboardMetrics(): array {
        // In a real system, these would be dynamic queries
        return [
            'total_children' => 142,
            'hiv_pending'    => 12,
            'meds_due'       => 8,
            'active_nurses'  => 5
        ];
    }
}