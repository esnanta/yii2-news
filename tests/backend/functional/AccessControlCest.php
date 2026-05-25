<?php

namespace tests\backend\functional;

use tests\backend\FunctionalTester;
use tests\backend\_pages\LoginPage;

class AccessControlCest
{
    public function guestCannotAccessDashboard(FunctionalTester $I): void
    {
        $I->amOnPage('/');

        $I->seeInCurrentUrl('/sign-in/login');
        $I->canSeeResponseCodeIs(200);
    }

    public function authenticatedUserCanAccessDashboard(FunctionalTester $I): void
    {
        $loginPage = LoginPage::openBy($I);
        $loginPage->login('manager', 'manager');

        $I->canSeeResponseCodeIs(200);
        $I->seeLink('Logout');
    }

    public function unauthorizedRoleCannotAccessArticleCreate(FunctionalTester $I): void
    {
        $loginPage = LoginPage::openBy($I);
        $loginPage->login('user', 'user');

        $I->canSeeResponseCodeIs(403);
        $I->amOnPage('/content/article/create');
        $I->canSeeResponseCodeIs(403);
    }
}

