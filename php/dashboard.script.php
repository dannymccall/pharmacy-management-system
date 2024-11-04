<?php
include '../cors/cors.php';
include '../db/db.php';
include './util.script.php';

$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

if ($method === 'GET' && $service === 'getDashboardDetails') {
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;

    try {
        $expenses = fetchFromDatabaseWithCount($pdo, 'expenses');
        $sales = fetchFromDatabaseWithCount($pdo, 'invoices');
        $medicines = fetchFromDatabaseWithCount($pdo, 'medicines');
        $purchases = fetchFromDatabaseWithCount($pdo, 'purchases');
        $lowOnStockCodition = "WHERE quantity < 20";

        $lowStockCount = fetchFromDatabaseWithCount($pdo, 'medicines', $lowOnStockCodition, true);
        $salesByMonth = fetchFromDatabase(
            $pdo,
            'invoices',
            "DATE_FORMAT(dateofsale, '%Y-%m') AS sale_month, SUM(subtotal) AS total_sales",
            '',
            "sale_month",
            "sale_month"
        );

        $months = [];
        $totals = [];

        foreach ($salesByMonth as $month) {
            $months[] = $month['sale_month'];
            $totals[] = $month['total_sales'];
        }
        $expectedRevenue = null;
        $totalExpense = null;
        $totalProfit = null;
        $totalPurchases = null;
        $totalSales = null;
        foreach ($expenses as $expense) {
            $totalExpense += $expense['total'];
        }

        foreach ($sales as $sale) {
            $totalProfit += $sale['totalprofit'];
        }

        foreach ($medicines as $medicine) {
            $unitProfit = $medicine['medicinesellingunitprice'] - $medicine['medicinecostunitprice'];
            $expectedRevenue += $unitProfit * $medicine['quantity'];
        }

        foreach($purchases as $purchase)
            $totalPurchases += $purchase['subtotal'];

        foreach($sales as $sale)
            $totalSales += $sale['subtotal'];

        $today = date('Y-m-d');
        $total_items = fetchFromDatabaseWithCount($pdo, 'invoices', "WHERE DATE(dateofsale) = '$today'", true);

        $invoices = fetchFromDatabase(
            $pdo,
            'invoices',
            '*',
            "WHERE DATE(dateofsale) = '2024-11-03'",
            '',
            'dateofsale DESC', // Order by most recent sales
            "$offset, $items_per_page",
            ''              // Limit to 10 records
        );
        $todaysActivities = fetchFromDatabase(
            $pdo,
            'activitymanagement a',
            'a.userId, a.created_at, u.username, a.activity',
            "WHERE DATE(a.created_at) = '2024-11-03'",
            '',
            'created_at DESC', // Order by most recent sales
            "$offset, $items_per_page",
            "JOIN users u ON a.userId = u.id"
            // Limit to 10 records
        );

        echo json_encode([
            'success' => true,
            'data' =>
                [
                    'totalExpense' => $totalExpense,
                    'totalProfit' => $totalProfit,
                    'expectedRevenue' => $expectedRevenue,
                    'lowStockCondition' => $lowStockCount,
                    'monthSales' => $months,
                    'monthTotals' =>$totals,
                    'totalSales' => $totals,
                    'total_items' => $total_items,
                    'totalPurchases' => $totalPurchases,
                    'todaySales' => [
                        'invoices' => $invoices,
                        'total_items' => $total_items,
                        'items_per_page' => $items_per_page,
                        'current_page' => $page
                    ],
                    'todaysActivities' => [
                        'activity' => $todaysActivities,
                        'total_items' => $total_items,
                        'items_per_page' => $items_per_page,
                        'current_page' => $page
                    ],
                    'totalInvoiceSales' => $totalSales
                ]
        ]);
        return;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        return;
    }
}