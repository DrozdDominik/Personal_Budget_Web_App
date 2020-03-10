<?php
session_start();

if(!isset($_SESSION['logged_id']))
{
    header('Location: index.php');
}

$current_date = new DateTime();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.2/bootstrap-float-label.min.css"/>
    <link rel="shortcut icon" type="image/ico" href="img/favicon.png">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Balance</title>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <p class="text-primary">Personal Budget</p>
                <p class="ml-auto">Zalogowany jako:
                    <span class="text-success"><?= $_SESSION['logged_user'] ?></span>
                </p>
                <a href="logout.php" class="btn btn-danger ml-2">Wyloguj</a>
            </div>
        </nav>
        <header class="header"></header>
        <div class="jumbotron">
            <h1 class="display-4 text-center">Bilans</h1>
            <p class="lead text-center text-success leadTarget">Niestandardowy</p>
            <?php
                echo '<p class="lead text-center text-success leadTarget">Zakres od: '.$_SESSION["first_date"].' do: '.$_SESSION["second_date"].'</p>';
            ?>
            <hr class="my-4">
            <div class="d-flex justify-content-center">
                <img src="img/logo.png" class="header__logo img-fluid" alt="logo aplikacji">
            </div>
            <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
                <div class="dropdown">
                    <button class="btn btn-dark text-success dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-calendar-alt mr-1" ></i>Wybierz okres
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <a href="balance.php" class="dropdown-item">Bieżący miesiąc</a>
                        <a href="balance_previous_month.php" class="dropdown-item">Poprzedni miesiąc</a>
                        <a href="balance_current_year.php" class="dropdown-item">Bieżący rok</a>
                        <a href="balance_custom.php" class="dropdown-item" data-toggle="modal" data-target="#dateModal">Niestandardowy</a>
                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarMenu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="income.php" class="nav-link"><i class="fas fa-wallet mr-1"></i>Dodaj przychód</a>
                        </li>
                        <li class="nav-item">
                            <a href="expense.php" class="nav-link"><i class="fas fa-shopping-cart mr-1"></i>Dodaj wydatek</a>
                        </li>
                        <li class="nav-item">
                            <a href="balance.php" class="nav-link"><i class="fas fa-balance-scale mr-1"></i>Przeglądaj bilans</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="fas fa-wrench mr-1"></i>Ustawienia</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Wyloguj się</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 text-center col-lg-6 mb-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Przychody</h5>

                        <?php 
                            require_once 'database.php';
                            $id_user = $_SESSION['logged_id']; 
                                            
                                $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND incomes.date_of_income BETWEEN :first_date AND :second_date GROUP BY Category";
                                $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
                                $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                                $query_select_incomes_sum->bindValue(':first_date', $_SESSION['first_date'], PDO::PARAM_STR);
                                $query_select_incomes_sum->bindValue(':second_date', $_SESSION['second_date'], PDO::PARAM_STR);
                                $query_select_incomes_sum->execute();
                            
                                $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
                            
                                foreach($result_sum_of_incomes as $custom_incomes)
                                {
                                    $sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND incomes.date_of_income BETWEEN :first_date AND :second_date AND category_incomes.name = :category_name";
                                    $query_select_incomes_details = $db->prepare($sql_incomes_details);
                                    $query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                                    $query_select_incomes_details->bindValue(':first_date', $_SESSION['first_date'], PDO::PARAM_STR); 
                                    $query_select_incomes_details->bindValue(':second_date', $_SESSION['second_date'], PDO::PARAM_STR);  
                                    $query_select_incomes_details->bindValue(':category_name', $custom_incomes[0], PDO::PARAM_INT);   $query_select_incomes_details->execute();

                                    $result_details_of_incomes = $query_select_incomes_details->fetchAll();

                                     echo '<div class="card-header">'.$custom_incomes[0].': '.$custom_incomes[1].'zł'.'</div>';
                                     foreach($result_details_of_incomes as $incomes_details)
                                    {
                                          echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$incomes_details[0].' - '.$incomes_details[1].': '.$incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                                    }         
                                }                      
                                                                               
                            ?>                           
                    </div>
                </div>
            </div>
            <div class="col-12 text-center col-lg-6">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Wydatki</h5>
                            <?php 
                                $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND expenses.date_of_expense BETWEEN :first_date AND :second_date GROUP BY Category";
                                $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
                                $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                                $query_select_expenses_sum->bindValue(':first_date', $_SESSION['first_date'], PDO::PARAM_STR);
                                $query_select_expenses_sum->bindValue(':second_date', $_SESSION['second_date'], PDO::PARAM_STR);
                                $query_select_expenses_sum->execute();
                            
                                $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
                            
                                foreach($result_sum_of_expenses as $custom_expenses)
                                {
                                    $sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND expenses.date_of_expense BETWEEN :first_date AND :second_date AND category_expenses.name = :category_name";
                                    $query_select_expenses_details = $db->prepare($sql_expenses_details);
                                    $query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                                    $query_select_expenses_details->bindValue(':first_date', $_SESSION['first_date'], PDO::PARAM_STR); 
                                    $query_select_expenses_details->bindValue(':second_date', $_SESSION['second_date'], PDO::PARAM_STR);
                                    $query_select_expenses_details->bindValue(':category_name', $custom_expenses[0], PDO::PARAM_INT);  
                                    $query_select_expenses_details->execute();

                                    $result_details_of_expenses = $query_select_expenses_details->fetchAll();

                                     echo '<div class="card-header">'.$custom_expenses[0].': '.$custom_expenses[1].'zł'.'</div>';
                                     foreach($result_details_of_expenses as $expenses_details)
                                    {
                                          echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$expenses_details[0].' - '.$expenses_details[1].': '.$expenses_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                                    }         
                                }                      
                                                                               
                            ?>
                </div>
            </div>
        </div>
        <div class="col-12 my-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title text-center display-4">Bilans</h5>
                    <div class="card-header text-success display-4 text-center">
                    <?php 
                        $incomes_sum = 0;                    
                        foreach($result_sum_of_incomes as $month_incomes)
                        {                          
                            $incomes_sum += $month_incomes[1];
                        }    

                        $expenses_sum = 0;
                        foreach($result_sum_of_expenses as $month_expenses)
                        {                          
                            $expenses_sum += $month_expenses[1];
                        }    
                         
                        $balance = $incomes_sum - $expenses_sum;

                        echo $balance.'zł';
                    ?>
                    </div>                
                    <?php
                        if($balance >= 0)
                        {
                            echo '<p class="card-footer text-primary text-center">Gratulacje. Świetnie zarządzasz finansami!</p>';
                        }
                        else echo '<p class="card-footer text-danger text-center">Uważaj, wpadasz w długi!</p>';
                    ?>                    
                </div>
                </div>
            </div>
        </div>
        <div class="display-4 text-center">Wydatki</div>
        <div id="chartWrap"></div>
        <div id="piechart"></div>
    <div class="modal" tabindex="-1" role="dialog" id="dateModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Wybierz zakres dat:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="modal.php" method='post'>
                    <div class="modal-body">
                        <p>Zakres od:</p>
                        <input type="date" name="first_date">
                        <span>do</span>
                        <input type="date" name="second_date">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  

<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() 
    {
        const data = google.visualization.arrayToDataTable([
            ['Wydatek', 'zł'],
            <?php
                foreach ($result_sum_of_expenses as $expense)
                {
                    echo "['".$expense[0]."',".$expense[1]."],";
                }
            ?>
        ]);

        const options = {
            legend: {position: 'bottom', alignment: 'center'},
            chartArea:{width:'100%',height:'400px'},
    };

    const chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
    }    

</script>                  

    <script src="balanceScript.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>