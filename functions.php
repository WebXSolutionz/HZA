<?php
function check_login($pdo)
{

    if (isset($_SESSION['user_name']))
    {
        try
        {

            $username = $_SESSION['user_name'];
            $select_stmt = $pdo->prepare("SELECT * FROM user_data WHERE user_name=:uname limit 1;");
            $select_stmt->execute(array(
                ':uname' => $username
            ));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0)
            {
                return $row;
            }
            else
            {
                //redirect to login page if the above code is unsuccessful
                header("Location: index.php");
                die;
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }

    }
    else
    {
        //redirect to login page if the above code is unsuccessful
        header("Location: index.php");
        die;
    }
}


?>
