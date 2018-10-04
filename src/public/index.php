<?php

session_start();

//LDAPの接続情報
const LDAP_HOST = "openldap-container";
const LDAP_PORT = 389;
const LDAP_DC = "dc=example,dc=org";
const LDAP_DN = "cn=admin,dc=example,dc=org";
const LDAP_PASS = "admin";

if (isset($_POST["logout"])) {
    session_destroy();
    header('Location: /', true , 301);
    exit;
}

if (isset($_POST["login"])) {
    $userId = $_POST['user_id'];
    $password = $_POST['password'];

    // エスケープ処理
    // $userId = ldap_escape($userId);
    // $password = ldap_escape($password);

    // LDAPに接続
    $ldapConn = ldap_connect(LDAP_HOST, LDAP_PORT);
    if (!$ldapConn) {
        exit('ldap_conn');
    }

    // バインド
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    $ldapBind = ldap_bind($ldapConn, LDAP_DN,LDAP_PASS);
    if ($ldapBind) {

        // ログイン処理
        $filter = '(&(cn=' . $userId . ')(userPassword=' . $password . '))'; // IDとパスワードのAND条件でフィルタを作成
        $ldapSearch = ldap_search($ldapConn, LDAP_DC, $filter);
        $getEntries = ldap_get_entries($ldapConn, $ldapSearch);
        if ($getEntries['count'] > 0) {
            // 成功
            $_SESSION["USERID"] = $userId;
            header('Location: /', true , 301);
            exit;
        }
    } else {
        // 失敗
    }
}

?>

<html>
<?= $_SESSION["USERID"] ?>さん こんにちは
<form action="/" method="POST">
    <label>User ID: </label><input type="text" name="user_id"/>
    <label>Password: </label><input type="password" name="password"/>
    <input type="hidden" name="login" value="1"/>
    <input type="submit" name="submit" value="Submit"/>
</form>

<form action="/" method="POST">
    <input type="hidden" name="logout" value="1"/>
    <input type="submit" value="Logout"/>
</form>
</html>
