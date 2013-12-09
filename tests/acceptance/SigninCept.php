<?php
$I = new WebGuy($scenario);
$I->wantTo('log in as regular user');
$I->amOnPage('customers/signin');
$I->see('Authorization');
$I->fillField('email','php.michael@gmail.com');
$I->fillField('password','codemaster7');
$I->click('Login');
$I->see('Logout');
?>