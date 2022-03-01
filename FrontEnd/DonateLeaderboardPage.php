<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    include('Connection.php');
    $_SESSION["back_page"] = "DonateLeaderboardPage.php";

    $q = "SELECT *, Sum(Amount) as Total_Amount, max(Amount) as Max_Amount FROM DonationHistory
     group by username order by Total_Amount DESC Limit 10;";

    if (($result = $link->query($q))) {
    } else {
        $_SESSION["error_message"] = "Query Error";

        header("location:../FrontEnd/ErrorPage.php");
    }
?>
    <html>

    <head>
        <title> Donate Leaderboard Page </title>
        <link rel="stylesheet" href="CSS/Style.css">
        <link rel="stylesheet" href="CSS/DonateLeaderboardPage.css">
    </head>

    <body>

        <?php
        include('Header.php');
        ?>

        <main class="main center-parent" style="flex-direction: column;">
            <div class="center-parent heading-cell" style="font-weight: bold;">
                <div style="width: 5vw;"> Sr No. </div>
                <div style="width: 15vw;"> Username </div>
                <div> Email </div>
                <div style="width: 10vw;"> Total Donated </div>
                <div style="width: 20vw;"> Highest Donated </div>
            </div>

            <?php
            $i=1;
            while ($user_data = $result->fetch_assoc()) {
            ?>
                <div class="center-parent odd-cell">
                    <div style="width: 5vw;"> <?php echo $i++; ?> </div>
                    <div style="width: 15vw;"> <?php echo $user_data["Username"] ?> </div>
                    <div> <?php echo $user_data["Email"] ?> </div>
                    <div style="width: 10vw;"> <?php echo $user_data["Total_Amount"] ?> </div>
                    <div style="width: 20vw;"> <?php echo $user_data["Max_Amount"] ?> </div>
                </div>
            <?php } ?>

        </main>

        <?php
        include('Footer.php');
        ?>

    </body>

    </html>

<?php
} else {
    header("location:../FrontEnd/LogInPage.php");
}
?>