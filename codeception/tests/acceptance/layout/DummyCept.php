<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('see the logo on the home page');
$I->amOnPage('/');
$I->seeElement('//img[@src="/img/logo.png"]');
