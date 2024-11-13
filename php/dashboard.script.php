<?php
include '../cors/cors.php';
include '../db/db.php';
include './util.script.php';

$method = $_SERVER["REQUEST_METHOD"];
$service = $_SERVER["HTTP_SERVICE"];

if ($method === 'GET' && $service === 'getDashboardDetails') {
    // $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    // $items_per_page = 5;
    // $offset = ($page - 1) * $items_per_page;

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
        $notifications = null;
        $todaysTotalPurchase = 0.00;
        $todaysTotalExpense = 0.00;
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

        foreach ($purchases as $purchase) {
            $totalPurchases += $purchase['subtotal'];
            $purchaseProduct = json_decode($purchase['products'], true);
            $purchaseID = $purchase['purchasenumber'];
            $notifications = getExpirationAlert($purchaseProduct, $purchaseID);
        }

        foreach ($sales as $sale)
            $totalSales += $sale['subtotal'];

        date_default_timezone_set('UTC');
        $today = date('Y-m-d');
        // $total_items = fetchFromDatabaseWithCount($pdo, 'invoices', "WHERE DATE(created_at) = '2024-11-03'", true);

        $invoices = fetchFromDatabase(
            $pdo,
            'invoices',
            '*',
            "WHERE DATE(dateofsale) = '$today'",
            '',
            '', // Order by most recent sales
            '',
            ''              // Limit to 10 records
        );

        $todaysPurchases = fetchFromDatabase(
            $pdo,
            'purchases',
            '*',
            "WHERE DATE(date) = '$today'",
            '',
            '',
            '',
            ''
        );

        $todaysExpenses = fetchFromDatabase(
            $pdo,
            'expenses',
            '*',
            "WHERE DATE(created_at) = '$today'",
            '',
            '',
            '',
            ''
        );

        foreach ($todaysPurchases as $purchases)
            $todaysTotalPurchase += $purchase['subtotal'];

        foreach ($todaysExpenses as $expense)
            $todaysTotalExpense += $expense['total'];

        echo json_encode([
            'success' => true,
            'data' =>
                [
                    'totalExpense' => $totalExpense,
                    'totalProfit' => $totalProfit,
                    'expectedRevenue' => $expectedRevenue,
                    'lowStockCondition' => $lowStockCount,
                    'monthSales' => $months,
                    'monthTotals' => $totals,
                    'totalSales' => $totals,
                    'totalPurchases' => $totalPurchases,
                    'todaySales' => $invoices,
                    'totalInvoiceSales' => $totalSales,
                    'notifications' => $notifications,
                    'todaysPurchase' => $todaysTotalPurchase,
                    'todaysExpense' => $todaysTotalExpense
                ]
        ]);
        return;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        return;
    }
}