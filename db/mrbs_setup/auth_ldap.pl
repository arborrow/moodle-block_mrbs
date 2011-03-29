#!/usr/bin/perl -w

# $Id: auth_ldap.pl,v 1.1 2007/04/05 22:25:18 arborrow Exp $

$server = shift;
$dn = shift;
$password = shift;

use Net::LDAP qw(LDAP_SUCCESS);

$ldap = Net::LDAP->new($server) or exit 1;

$msg = $ldap->bind(dn => $dn, password => $password);

exit $msg->code;
