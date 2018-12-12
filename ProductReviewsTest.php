<?php

namespace XLiteWeb\tests;

use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * @author cerber
 */
class testProductReviewsTest extends \XLiteWeb\AXLiteWeb
{
    public function testChangeRatingOnProductPage()
    {
        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $this->assertFalse($customProduct->isSetRating(), 'Error validating add Raitind on page.');

    }

    public function testAddReviewOnProductPage()
    {

        $customProduct = $this->CustomerProduct;
        $customProduct->load(true,37);
        $customProduct->buttonAddReview();   //addReview();

        $rating = 1;
        $nameOwnReview = "My name is Cerber";
        $txtReview     = "Very good product";

        $customProduct->componentAddReview->setRating($rating);
        $customProduct->componentAddReview->setName($nameOwnReview);
        $customProduct->componentAddReview->setReview($txtReview);

        $customProduct->componentAddReview->get_buttonSubmit->click();

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($rating,     $customProduct->getRating(), 'Error validating rating');
        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview,     $customProduct->getTxtReview(), 'Error validating review');

    }

    public function testEditReviewOnProductPage()
    {

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->buttonEditReview();

        $rating = 4;
        $nameOwnReview = "My name is Cerber Edit";
        $txtReview     = "Very good product Edit";

        $customProduct->componentAddReview->setRating($rating);
        $customProduct->componentAddReview->setName($nameOwnReview);
        $customProduct->componentAddReview->setReview($txtReview);

        $customProduct->componentAddReview->get_buttonSubmit->click();

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($rating,     $customProduct->getRating(), 'Error validating rating');
        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview,     $customProduct->getTxtReview(), 'Error validating review');

    }

    public function testRemoveReviewOnAdminAddReviewsPage()
    {

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $adminProduct->buttonProductReview();

        $adminProduct->componentAddReview->get_buttonRemove->click();

        $isDeleteReview = $adminProduct->buttonProductReview();

        $this->assertFalse($isDeleteReview, 'Review was not removed');

    }

    public function testApproveReviewOnAdminProductReviewsPage()
    {

        //======Создание на странице продукта в Кастомерской зоне=============================================

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->buttonAddReview();

        $nameOwnReview = "My name is Cerber";
        $txtReview     = "Very good product";

        $customProduct->componentAddReview->setName($nameOwnReview);
        $customProduct->componentAddReview->setReview($txtReview);

        $customProduct->componentAddReview->get_buttonSubmit->click();

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview, $customProduct->getTxtReview(), 'Error validating review');

        //=============================================================================================

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $statusBeforeApproveReview = $adminProduct->getStatusProductReview();

        $adminProduct->buttonProductReview();

        $rating = 2;
        $nameOwnReview = "My name is Cerber Approve Edit";
        $txtReview     = "Very good product Approve Edit";

        $adminProduct->componentAddReview->setRating($rating);
        $adminProduct->componentAddReview->setName($nameOwnReview);
        $adminProduct->componentAddReview->setReview($txtReview);

        $adminProduct->componentAddReview->get_buttonApprove->click();

        $statusAfterApproveReview = $adminProduct->getStatusProductReview();

        if ($statusBeforeApproveReview === 'Pending' and $statusAfterApproveReview  === 'Published') {

            $isStatusApprove = true;

        } else {

            $isStatusApprove = false;

        }

        $this->assertTrue($isStatusApprove, 'Error Status Approve.');

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($rating, $customProduct->getRating(), 'Error validating rating');

        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview    , $customProduct->getTxtReview(), 'Error validating review');

    }

    public function testUpdateReviewOnAdminProductReviewsPage()
    {

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $adminProduct->buttonProductReview();

        $rating = 3;
        $nameOwnReview = "My name is Cerber Update On Admin Page";
        $txtReview     = "Very good product Update On Admin Page";

        $adminProduct->componentAddReview->setRating($rating);
        $adminProduct->componentAddReview->setName($nameOwnReview);
        $adminProduct->componentAddReview->setReview($txtReview);

        $adminProduct->componentAddReview->buttonUpdate();

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($rating, $customProduct->getRating(), 'Error validating rating');
        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview, $customProduct->getTxtReview(), 'Error validating review');

    }

    public function testAddResponseOnAdminProductReviewsPage()
    {

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $adminProduct->buttonProductReview();

        $nameOwnReview = "My name is Cerber Add Response";
        $txtReview     = "Very good product Add Response";
        $txtResponse   = "Add Text area Add Response";

        $adminProduct->componentAddReview->get_linkAddResponse->click();

        $adminProduct->componentAddReview->setName($nameOwnReview);
        $adminProduct->componentAddReview->setReview($txtReview);
        $adminProduct->componentAddReview->setTextareaResponse($txtResponse);

        $adminProduct->componentAddReview->buttonUpdate();

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview,     $customProduct->getTxtReview(),     'Error validating review');
        $this->assertEquals($txtResponse,   $customProduct->getTxtResponse(),   'Error validating response');

    }

    public function testCountAverageRatingOnProductPage()
    {

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $arrayCountAverageRating = $adminProduct->countAverageRatingMultiPage();

        $countAverageRating = $arrayCountAverageRating[0];
        $countVotes = $arrayCountAverageRating[1];

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($countAverageRating, $customProduct->getAverageRating(), 'Error validating average rating');
        $this->assertEquals($countVotes, $customProduct->getCountVotes(), 'Error validating count review');

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $adminProduct->deleteProductReview();

        $isDeleteReview = $adminProduct->isProductReview();

        $this->assertFalse($isDeleteReview, 'Review was not removed');

    }

    public function testAddReviewOnAdminProductReviewsPage()
    {
        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $adminProduct->buttonAddReview();

        $rating = 3;
        $nameOwnReview        = "My name is Cerber Add On Admin Page";
        $txtReview            = "Very good product Add On Admin Page";
        $profileProductOnPage = 'Customer <bit-bucket+customer@example.com>';

        $getProductName = $adminProduct->componentAddReview->setProduct(1200);
        $adminProduct->componentAddReview->setRating($rating);

        $getProfile = $adminProduct->componentAddReview->setProfile("Customer");

        $adminProduct->componentAddReview->setName($nameOwnReview);
        $adminProduct->componentAddReview->setReview($txtReview);

        $adminProduct->componentAddReview->buttonCreate();

        $customProduct = $this->CustomerProduct;
        $customProduct->load(false,37);
        $customProduct->get_buttonTabReview->click();

        $this->assertEquals($rating, $customProduct->getRating(), 'Error validating rating');
        $this->assertEquals($nameOwnReview, $customProduct->getNameOwnReview(), 'Error validating name own review');
        $this->assertEquals($txtReview, $customProduct->getTxtReview(), 'Error validating review');
        $this->assertEquals($getProductName, $customProduct->getProductName(), 'Error validating name product');
        $this->assertEquals($getProfile, $profileProductOnPage, 'Error validating profile');

    }

    public function testDeleteReviewOnAdminProductReviewsPage()
    {

        $adminProduct = $this->AdminProductReviews;
        $adminProduct->loadProductId(true,37);

        $adminProduct->deleteProductReview();

        $isDeleteReview = $adminProduct->isProductReview();

        $this->assertFalse($isDeleteReview, 'Review was not removed');

    }

}
