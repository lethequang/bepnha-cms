<?php
/**
 * Created by PhpStorm.
 * User: giaulk
 * Date: 4/21/2016
 * Time: 9:43 AM
 */
namespace App\MyCore;

class Authentication {
    public function auth($email, $password) {
        /**
         * nếu env là local thì dùng API để auth, ngược lại thì dùng ldap
         */
		if (env('APP_ENV') == 'local') {
            $client = new \SoapClient('http://login.ho.fpt.vn/fpter?wsdl');

            $parameters = array('username' => $email, 'password' => $password);
            return $client->__call('authentication', $parameters);
        } else {
            $ldapconn = ldap_connect("ldap://210.245.0.150:389");

            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

            if ($ldapconn) {
                $ldapbind = ldap_bind($ldapconn, $email, $password);
                if ($ldapbind) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}