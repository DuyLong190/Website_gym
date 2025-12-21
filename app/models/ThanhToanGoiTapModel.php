<?php
class ThanhToanGoiTapModel
{
    private $db;
    private $table_name = 'thanhtoan_goitap';

    public function __construct($db)
    {
        $this->db = $db; // PDO instance
    }

    public function storeTransaction($customer_id, $id_ctgt, $amount, $momo_status, $link_data, $orderId = null)
    {
        try {
            // Kiểm tra id_ctgt có tồn tại không
            $ctgtQuery = "SELECT id_ctgt FROM chitiet_goitap WHERE id_ctgt = :id_ctgt LIMIT 1";
            $ctgtStmt = $this->db->prepare($ctgtQuery);
            $ctgtStmt->bindParam(':id_ctgt', $id_ctgt, PDO::PARAM_INT);
            $ctgtStmt->execute();
            $ctgt = $ctgtStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$ctgt) {
                error_log('ThanhToanGoiTapModel::storeTransaction - Không tìm thấy id_ctgt: ' . $id_ctgt);
                return false;
            }
            
            // Lưu orderId và id_ctgt vào link_data nếu cần
            $linkDataArray = json_decode($link_data, true);
            if (!is_array($linkDataArray)) {
                $linkDataArray = [];
            }
            $linkDataArray['id_ctgt'] = $id_ctgt;
            if ($orderId) {
                $linkDataArray['orderId'] = $orderId;
            }
            $link_data = json_encode($linkDataArray);
            
            // Kiểm tra xem bảng có cột id_ctgt và order_id không
            $columnsQuery = "SHOW COLUMNS FROM {$this->table_name} LIKE 'id_ctgt'";
            $columnsStmt = $this->db->prepare($columnsQuery);
            $columnsStmt->execute();
            $hasIdCtgt = $columnsStmt->fetch() !== false;
            
            $columnsQuery2 = "SHOW COLUMNS FROM {$this->table_name} LIKE 'order_id'";
            $columnsStmt2 = $this->db->prepare($columnsQuery2);
            $columnsStmt2->execute();
            $hasOrderId = $columnsStmt2->fetch() !== false;
            
            if ($hasIdCtgt && $hasOrderId) {
                // Bảng đã có các cột mới - chỉ lưu id_ctgt, không cần goitap_id
                $query = "INSERT INTO {$this->table_name} (customer_id, id_ctgt, amount, momo_status, link_data, order_id)
                          VALUES (:customer_id, :id_ctgt, :amount, :momo_status, :link_data, :order_id)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
                $stmt->bindParam(':id_ctgt', $id_ctgt, PDO::PARAM_INT);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':momo_status', $momo_status);
                $stmt->bindParam(':link_data', $link_data);
                $stmt->bindParam(':order_id', $orderId);
            } else {
                // Bảng chưa có các cột mới - fallback: chỉ lưu vào link_data
                // Lưu ý: Trường hợp này không nên xảy ra nếu database đã được cập nhật đúng
                $query = "INSERT INTO {$this->table_name} (customer_id, amount, momo_status, link_data)
                          VALUES (:customer_id, :amount, :momo_status, :link_data)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':momo_status', $momo_status);
                $stmt->bindParam(':link_data', $link_data);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('ThanhToanGoiTapModel::storeTransaction - Error: ' . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách giao dịch của hội viên
    public function getTransactionsByCustomer($customer_id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE customer_id = :customer_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái giao dịch (Admin duyệt)
    public function updateStatus($id, $status)
    {
        $query = "UPDATE {$this->table_name} SET momo_status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
