<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "budwebusers";
$connect = mysqli_connect($host, $user, $pass, $dbname);
if (!$connect) {
    die("Connection Failed: " . mysqli_connect_error());
}

function addBudget($userID, $budgetinput, $connect){
    $userID = mysqli_real_escape_string($connect, $userID);
    $budgetinput = mysqli_real_escape_string($connect, $budgetinput);

    $check_query = "SELECT * FROM budget WHERE userID = '$userID'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE budget SET total_budget = total_budget + $budgetinput WHERE userID = '$userID'";
        if (mysqli_query($connect, $update_query)) {
            header("location: ../Budgettracker/home.php");
        } else {
            echo "Error updating budget: " . mysqli_error($connect);
        }
    } else {
        $insert_query = "INSERT INTO budget (userID, total_budget) VALUES ('$userID', '$budgetinput')";
        if (mysqli_query($connect, $insert_query)) {
            header("location: ../Budgettracker/home.php");
        } else {
            echo "Error adding budget: " . mysqli_error($connect);
        }
    }
}

function remainingBudget($userID, $connect){
    $userID = mysqli_real_escape_string($connect, $userID);

    $budget_query = "SELECT total_budget FROM budget WHERE userID = '$userID'";
    $budget_result = mysqli_query($connect, $budget_query);
    if ($budget_row = mysqli_fetch_assoc($budget_result)) {
        $totalBudget = $budget_row['total_budget'];
    } else {
        echo "Error: Budget not found for user.";
        return;
    }

    $expenses_query = "SELECT SUM(expense_amount) AS total_expenses FROM expenses WHERE userID = '$userID'";
    $expenses_result = mysqli_query($connect, $expenses_query);
    if ($expenses_row = mysqli_fetch_assoc($expenses_result)) {
        $totalExpenses = $expenses_row['total_expenses'];
    } else {
        $totalExpenses = 0;
    }

    $remainingBudget = $totalBudget - $totalExpenses;
    return $remainingBudget;
}

function updateRemainingBudget($userID, $connect) {
    $remainingBudget = remainingBudget($userID, $connect);

    $update_query = "UPDATE budget SET remaining_budget = '$remainingBudget' WHERE userID = '$userID'";
    if (mysqli_query($connect, $update_query)) {
        echo "Remaining budget updated successfully!";
    } else {
        echo "Error updating remaining budget: " . mysqli_error($connect);
    }
}

function addExpenses($userID, $expenseName, $expenseInput, $connect){
    $userID = mysqli_real_escape_string($connect, $userID);
    $expenseName = mysqli_real_escape_string($connect, $expenseName);
    $expenseInput = mysqli_real_escape_string($connect, $expenseInput);

    $insert_query = "INSERT INTO expenses (userID, expense_name, expense_amount) 
                     VALUES ('$userID', '$expenseName', '$expenseInput')";
    if (mysqli_query($connect, $insert_query)) {
        header("location: ../Budgettracker/home.php");
    } else {
        echo "Error adding expense: " . mysqli_error($connect);
    }
}

function resetData($userID, $connect) {
    $reset_budget_query = "DELETE FROM budget WHERE userID = '$userID'";
    if (mysqli_query($connect, $reset_budget_query)) {
        header("location: ../Budgettracker/home.php");
    } else {
        echo "Error resetting budget and remaining budget: " . mysqli_error($connect) . "<br>";
    }
    
    $reset_expenses_query = "DELETE FROM expenses WHERE userID = '$userID'";
    if (mysqli_query($connect, $reset_expenses_query)) {
        header("location: ../Budgettracker/home.php");
    } else {
        echo "Error resetting expenses: " . mysqli_error($connect) . "<br>";
    }
}

function overallExpenses($userID, $connect) {
    $userID = mysqli_real_escape_string($connect, $userID);

    $query = "SELECT SUM(expense_amount) AS total_expenses FROM expenses WHERE userID = '$userID'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row['total_expenses'] !== null) {
            return $row['total_expenses'];
        } else {
            return 0;
        }
    } else {
        return "Error: " . mysqli_error($connect);
    }
}

function totalBudget($userID, $connect){
    $query = "SELECT total_budget FROM budget WHERE userID = '$userID'";
    $result = mysqli_query($connect, $query);
    if ($row = mysqli_fetch_assoc($result)) {
       return $row['total_budget'];
    } else {
        return "0";
    }
}

function totalRemainBudget($userID, $connect){
    $query = "SELECT remaining_budget FROM budget WHERE userID = '$userID'";
    $result = mysqli_query($connect, $query);
    if ($row = mysqli_fetch_assoc($result)) {
       return $row['remaining_budget'];
    } else {
       return "0";
    }
}

function fetchExpenseLogs($userID, $connect) {
    $query = "SELECT expenseID, expense_name, expense_amount FROM expenses WHERE userID = '$userID'";
    $result = mysqli_query($connect, $query);
    $logs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $logs[] = $row;
    }
    return $logs;
}

function removeExpense($expenseID, $connect) {
    $expenseID = mysqli_real_escape_string($connect, $expenseID);
    $delete_query = "DELETE FROM expenses WHERE expenseID = '$expenseID'";
    if (mysqli_query($connect, $delete_query)) {
        header("location: ../Budgettracker/home.php");
    } else {
        echo "Error removing expense: " . mysqli_error($connect);
    }
}

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
} else {
    die("User ID is not set in session.");
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["addbudget"])){
        $budget = $_POST["inputbudget"];
        addBudget($userID, $budget, $connect);
    }
    if (isset($_POST["addexpense"])) {
        $expenseName = $_POST["inputexpensestitle"];
        $expenseAmount = $_POST["inputexpenses"];
        addExpenses($userID, $expenseName, $expenseAmount, $connect);
        updateRemainingBudget($userID, $connect); 
    }
    if (isset($_POST["resetbutton"])){
        resetData($userID, $connect);
    }
    if (isset($_POST["removeexpense"])) {
        $expenseID = $_POST["expense_id"];
        removeExpense($expenseID, $connect);
        updateRemainingBudget($userID, $connect);
    }
    if (isset($_POST["logoutbutton"])){
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../LoginSignup/login.php");
        exit();
    }
}

$totalExpenses = overallExpenses($userID, $connect);
$remainingBudget = totalRemainBudget($userID, $connect);
$totalBudget = totalBudget($userID, $connect);
$expenseLogs = fetchExpenseLogs($userID, $connect);

mysqli_close($connect);
?>
