<?php
include "../databasehandler/budwebconnection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BudWeb</title>
    <link rel="stylesheet" type="text/css" href="../Asset/home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/jpg" href="../Components/budweb-high-resolution-logo.png">

</head>
<body>
    <div class="header">
        <img src="../Components/background1.jpg" class="header-image" alt="header-image">
        <div class="logo-container">
            <img src="../Components/budweb-high-resolution-logo.png" alt="logo" class="logo">
        </div>
    </div>
    <div class="main-container">
        <!-- Logs -->
        <div class="log-container">
            <!-- Budget -->
            <div class="overall_budget">
                <h3>Budget: <?php echo $totalBudget; ?></h3>
            </div>            
            <!-- Expenses -->
            <div class="overall_expenses">
                <h3>Total Expenses: <?php echo $totalExpenses; ?></h3>
            </div>
            <!-- Budget remaining -->
            <div class="remaining_budget">
                <h3>Remaining Budget: <?php echo $remainingBudget; ?></h3>
            </div>
            <!-- Expense Log -->
            <div class="expense_log">
                <h3>Expense Logs:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Expense Name</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expenseLogs as $expense) { ?>
                            <tr>
                                <td><?php echo $expense['expense_name']; ?></td>
                                <td><?php echo $expense['expense_amount']; ?></td>
                                <td>
                                <form method="post" action="../databasehandler/budwebconnection.php">
                                    <input type="hidden" name="expense_id" value="<?php echo $expense['expenseID']; ?>">
                                    <button type="submit" name="removeexpense" class="remove_button">Remove</button>
                                </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="right-column">
            <!-- add budget -->
            <div class="add-budget-container">
                <h2>Add Budget</h2>
                <form id="add-budget-form" method="post" action="../databasehandler/budwebconnection.php">
                    <input type="number" name="inputbudget" class="user_input" placeholder="Enter budget">
                    <button class="add_budget_button" type="submit" name="addbudget">Add Budget</button>
                </form>
            </div>
            <!-- add expenses -->
            <div class="add-expenses-container">
                <h2>Add Expenses</h2>
                <form id="add-expense-form" method="post" action="../databasehandler/budwebconnection.php">
                    <input type="text" name="inputexpensestitle" class="user_input" placeholder="Enter expense name">
                    <input type="number" name="inputexpenses" class="user_input" placeholder="Enter expense amount">
                    <button class="add_expense_button" type="submit" name="addexpense">Add Expense</button>
                </form>
            </div>
            <!-- reset button -->
            <form method="post" action="../databasehandler/budwebconnection.php">
                <div class="reset-container">
                    <button class="reset_button" type="submit" name="resetbutton">Reset</button>
                </div>
                <!-- Logout button -->
                <div class="logout-container">
                <button class="logout_button" type="submit" name="logoutbutton">Log out</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
