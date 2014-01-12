<?php
$I = new WebGuy($scenario);
$I->wantTo('log in as regular user');
$I->amOnPage('customers/signin');
$I->see('Authorization');
$I->fillField('email','test@test.com');
$I->fillField('password','testpass');
$I->click('Login');
$I->see('Logout');