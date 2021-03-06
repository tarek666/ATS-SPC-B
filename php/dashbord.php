<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="page">
        <div id="page_header">
            <h1>Projet SPC</h1>
            <h2>(Suivi de Présence du Collaborateur)</h2>
        </div>
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
            <li role="presentation"><a href="addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
            <li role="presentation"><a href="showall.php"><span class="glyphicon glyphicon-asterisk"></span>Report</a></li>
            <li role="presentation"><a href="login.php"><span class="glyphicon glyphicon-asterisk"></span>login</a></li>
        </ul>
        <?php
        error_reporting('E_ALL & ~E_NOTIC');
        require 'conn.php';
        if ($_GET['login'] == 'activ') {
            $id = intval($_GET['id']);
            $sql = 'UPDATE login SET activ=1 WHERE id=:id ';
            $stml = $conn->prepare($sql);
            $stml->bindParam(':id', $id, PDO::PARAM_INT);
            $stml->execute();
            header('location:dashbord.php');
        } elseif ($_GET['login'] == 'unactiv') {
            $id = intval($_GET['id']);
            $sql = 'UPDATE login SET activ=0 WHERE id=:id ';
            $stml = $conn->prepare($sql);
            $stml->bindParam(':id', $id, PDO::PARAM_INT);
            $stml->execute();
            header('location:dashbord.php');
        }
        $sql = 'SELECT * FROM login ORDER BY id';
        $stmt = $conn->query($sql);
        $count = $stmt->rowcount();
        $id = 1;
        if ($count) {
        ?>
        <table class="table">
            <tr>
                <td>id</td>
                <td>user name</td>
                <td>password</td>
                <td>time</time></td>
                <td>activ</td>
            </tr>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                if ($row->activ == 0) {
                    echo'
                    <tr>
                    <td>'.$id++."</td>
                    <td>{$row->username}</td>
                    <td>{$row->password}</td>
                    <td>{$row->Time}</td>
                    <td>{$row->activ}</td>
                    <td><a href ='dashbord.php?login=activ&id={$row->id}'>activ</a></td>
                            <td>{$row->timd}</td>
                    </tr>
                    ";
                } else if ($row->activ == 1) {
                    $date = "$row->Time";
                    $date = strtotime($date);
                    $date = date('H', $date);
                    echo'
                    <tr>
                    <td>'.$id++."</td>
                    <td>{$row->username}</td>
                    <td>{$row->password}</td>
                    <td>{$row->Time}</td>
                    <td>{$row->activ}</td>
                    <td>$date</td>
                    <td><a href ='dashbord.php?login=unactiv&id={$row->id}'>unactiv</a></td>
                    </tr>
                    ";
                }
            }
        ?>
        </table>
        <?php
            } else {
                // TODO: Display an error!
            }
        ?>
    </div>
</body>

</html>
