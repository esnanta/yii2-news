<?php

use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m240708_170001_insert_rbac_data
 * Migrasi ini bertanggung jawab untuk menyisipkan peran dan izin RBAC.
 * Ini harus dijalankan SETELAH migrasi pembuatan tabel RBAC.
 */
class m240708_170001_insert_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // PENTING: Bersihkan cache skema untuk memastikan DbManager melihat tabel yang baru dibuat
        Yii::$app->db->schema->refresh();

        // Inisialisasi DbManager *setelah* penyegaran skema
        $auth = new DbManager();
        $auth->db = Yii::$app->db;

        // Hapus data RBAC yang ada (jika ada) - Sekarang aman untuk dieksekusi setelah tabel dibuat dan cache disegarkan
        // Menggunakan {{%auth_assignment}} dll.
        $this->execute('DELETE FROM {{%auth_assignment}}');
        $this->execute('DELETE FROM {{%auth_item_child}}');
        $this->execute('DELETE FROM {{%auth_item}}');
        $this->execute('DELETE FROM {{%auth_rule}}');

        // Sisipkan peran
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $regular = $auth->createRole('regular');
        $regular->description = 'Reguler';
        $auth->add($regular);

        $guest = $auth->createRole('guest');
        $guest->description = 'Guest';
        $auth->add($guest);

        // Sisipkan izin (permissions) berdasarkan file SQL
        // Izin Pengguna
        $createUserOwner = $auth->createPermission('create-user-owner');
        $createUserOwner->description = 'Create User Owner';
        $auth->add($createUserOwner);

        $createUserRegular = $auth->createPermission('create-user-regular');
        $createUserRegular->description = 'Create User Regular';
        $auth->add($createUserRegular);

        $updateProfile = $auth->createPermission('update-profile');
        $updateProfile->description = 'Update Profile';
        $auth->add($updateProfile);

        $viewProfile = $auth->createPermission('view-profile');
        $viewProfile->description = 'View Profile';
        $auth->add($viewProfile);

        // Menambahkan izin 'delete-profile' secara eksplisit
        $deleteProfile = $auth->createPermission('delete-profile');
        $deleteProfile->description = 'Delete Profile';
        $auth->add($deleteProfile);

        // Izin Master
        $indexMaster = $auth->createPermission('index-master');
        $indexMaster->description = 'Index Master';
        $auth->add($indexMaster);

        $createMaster = $auth->createPermission('create-master');
        $createMaster->description = 'Create Master';
        $auth->add($createMaster);

        $updateMaster = $auth->createPermission('update-master');
        $updateMaster->description = 'Update Master';
        $auth->add($updateMaster);

        $viewMaster = $auth->createPermission('view-master');
        $viewMaster->description = 'View Master';
        $auth->add($viewMaster);

        $deleteMaster = $auth->createPermission('delete-master');
        $deleteMaster->description = 'Delete Master';
        $auth->add($deleteMaster);

        $reportMaster = $auth->createPermission('report-master');
        $reportMaster->description = 'Report Master';
        $auth->add($reportMaster);

        // Izin Transaksi
        $indexTransaction = $auth->createPermission('index-transaction');
        $indexTransaction->description = 'Index Transaction';
        $auth->add($indexTransaction);

        $createTransaction = $auth->createPermission('create-transaction');
        $createTransaction->description = 'Create Transaction';
        $auth->add($createTransaction);

        $updateTransaction = $auth->createPermission('update-transaction');
        $updateTransaction->description = 'Update Transaction';
        $auth->add($updateTransaction);

        $viewTransaction = $auth->createPermission('view-transaction');
        $viewTransaction->description = 'View Transaction';
        $auth->add($viewTransaction);

        $deleteTransaction = $auth->createPermission('delete-transaction');
        $deleteTransaction->description = 'Delete Transaction';
        $auth->add($deleteTransaction);

        $reportTransaction = $auth->createPermission('report-transaction');
        $reportTransaction->description = 'Report Transaction';
        $auth->add($reportTransaction);

        // Izin Artikel
        $indexArticle = $auth->createPermission('index-article');
        $indexArticle->description = 'Index Article';
        $auth->add($indexArticle);

        $createArticle = $auth->createPermission('create-article');
        $createArticle->description = 'Create Article';
        $auth->add($createArticle);

        $updateArticle = $auth->createPermission('update-article');
        $updateArticle->description = 'Update Article';
        $auth->add($updateArticle);

        $viewArticle = $auth->createPermission('view-article');
        $viewArticle->description = 'View Article';
        $auth->add($viewArticle);

        $deleteArticle = $auth->createPermission('delete-article');
        $deleteArticle->description = 'Delete Article';
        $auth->add($deleteArticle);

        $reportArticle = $auth->createPermission('report-article');
        $reportArticle->description = 'Report Article';
        $auth->add($reportArticle);

        // Izin Kategori Artikel
        $indexArticleCategory = $auth->createPermission('index-articlecategory');
        $indexArticleCategory->description = 'Index Article Category';
        $auth->add($indexArticleCategory);

        $createArticleCategory = $auth->createPermission('create-articlecategory');
        $createArticleCategory->description = 'Create Article Category';
        $auth->add($createArticleCategory);

        $updateArticleCategory = $auth->createPermission('update-articlecategory');
        $updateArticleCategory->description = 'Update Article Category';
        $auth->add($updateArticleCategory);

        $viewArticleCategory = $auth->createPermission('view-articlecategory');
        $viewArticleCategory->description = 'View Article Category';
        $auth->add($viewArticleCategory);

        $deleteArticleCategory = $auth->createPermission('delete-articlecategory');
        $deleteArticleCategory->description = 'Delete Article Category';
        $auth->add($deleteArticleCategory);

        $reportArticleCategory = $auth->createPermission('report-articlecategory');
        $reportArticleCategory->description = 'Report Article Category';
        $auth->add($reportArticleCategory);

        // Izin Aset
        $indexAsset = $auth->createPermission('index-asset');
        $indexAsset->description = 'Index Asset';
        $auth->add($indexAsset);

        $createAsset = $auth->createPermission('create-asset');
        $createAsset->description = 'Create Asset';
        $auth->add($createAsset);

        $updateAsset = $auth->createPermission('update-asset');
        $updateAsset->description = 'Update Asset';
        $auth->add($updateAsset);

        $viewAsset = $auth->createPermission('view-asset');
        $viewAsset->description = 'View Asset';
        $auth->add($viewAsset);

        $deleteAsset = $auth->createPermission('delete-asset');
        $deleteAsset->description = 'Delete Asset';
        $auth->add($deleteAsset);

        $reportAsset = $auth->createPermission('report-asset');
        $reportAsset->description = 'Report Asset';
        $auth->add($reportAsset);

        // Izin Kategori Aset
        $indexAssetCategory = $auth->createPermission('index-assetcategory');
        $indexAssetCategory->description = 'Index Asset Category';
        $auth->add($indexAssetCategory);

        $createAssetCategory = $auth->createPermission('create-assetcategory');
        $createAssetCategory->description = 'Create Asset Category';
        $auth->add($createAssetCategory);

        $updateAssetCategory = $auth->createPermission('update-assetcategory');
        $updateAssetCategory->description = 'Update Asset Category';
        $auth->add($updateAssetCategory);

        $viewAssetCategory = $auth->createPermission('view-assetcategory');
        $viewAssetCategory->description = 'View Asset Category';
        $auth->add($viewAssetCategory);

        $deleteAssetCategory = $auth->createPermission('delete-assetcategory');
        $deleteAssetCategory->description = 'Delete Asset Category';
        $auth->add($deleteAssetCategory);

        $reportAssetCategory = $auth->createPermission('report-assetcategory');
        $reportAssetCategory->description = 'Report Asset Category';
        $auth->add($reportAssetCategory);

        // Izin Penulis
        $indexAuthor = $auth->createPermission('index-author');
        $indexAuthor->description = 'Index Author';
        $auth->add($indexAuthor);

        $createAuthor = $auth->createPermission('create-author');
        $createAuthor->description = 'Create Author';
        $auth->add($createAuthor);

        $updateAuthor = $auth->createPermission('update-author');
        $updateAuthor->description = 'Update Author';
        $auth->add($updateAuthor);

        $viewAuthor = $auth->createPermission('view-author');
        $viewAuthor->description = 'View Author';
        $auth->add($viewAuthor);

        $deleteAuthor = $auth->createPermission('delete-author');
        $deleteAuthor->description = 'Delete Author';
        $auth->add($deleteAuthor);

        // Izin Media Penulis
        $indexAuthorMedia = $auth->createPermission('index-authormedia');
        $indexAuthorMedia->description = 'Index Author Media';
        $auth->add($indexAuthorMedia);

        $createAuthorMedia = $auth->createPermission('create-authormedia');
        $createAuthorMedia->description = 'Create Author Media';
        $auth->add($createAuthorMedia);

        $updateAuthorMedia = $auth->createPermission('update-authormedia');
        $updateAuthorMedia->description = 'Update Author Media';
        $auth->add($updateAuthorMedia);

        $viewAuthorMedia = $auth->createPermission('view-authormedia');
        $viewAuthorMedia->description = 'View Author Media';
        $auth->add($viewAuthorMedia);

        $deleteAuthorMedia = $auth->createPermission('delete-authormedia');
        $deleteAuthorMedia->description = 'Delete Author Media';
        $auth->add($deleteAuthorMedia);

        // Izin Pekerjaan
        $indexEmployment = $auth->createPermission('index-employment');
        $indexEmployment->description = 'Index Employment';
        $auth->add($indexEmployment);

        $createEmployment = $auth->createPermission('create-employment');
        $createEmployment->description = 'Create Employment';
        $auth->add($createEmployment);

        $updateEmployment = $auth->createPermission('update-employment');
        $updateEmployment->description = 'Update Employment';
        $auth->add($updateEmployment);

        $viewEmployment = $auth->createPermission('view-employment');
        $viewEmployment->description = 'View Employment';
        $auth->add($viewEmployment);

        $deleteEmployment = $auth->createPermission('delete-employment');
        $deleteEmployment->description = 'Delete Employment';
        $auth->add($deleteEmployment);

        // Izin Acara
        $indexEvent = $auth->createPermission('index-event');
        $indexEvent->description = 'Index Event';
        $auth->add($indexEvent);

        $createEvent = $auth->createPermission('create-event');
        $createEvent->description = 'Create Event';
        $auth->add($createEvent);

        $updateEvent = $auth->createPermission('update-event');
        $updateEvent->description = 'Update Event';
        $auth->add($updateEvent);

        $viewEvent = $auth->createPermission('view-event');
        $viewEvent->description = 'View Event';
        $auth->add($viewEvent);

        $deleteEvent = $auth->createPermission('delete-event');
        $deleteEvent->description = 'Delete Event';
        $auth->add($deleteEvent);

        // Izin Kantor
        $indexOffice = $auth->createPermission('index-office');
        $indexOffice->description = 'Index Office';
        $auth->add($indexOffice);

        $createOffice = $auth->createPermission('create-office');
        $createOffice->description = 'Create Office';
        $auth->add($createOffice);

        $updateOffice = $auth->createPermission('update-office');
        $updateOffice->description = 'Update Office';
        $auth->add($updateOffice);

        $viewOffice = $auth->createPermission('view-office');
        $viewOffice->description = 'View Office';
        $auth->add($viewOffice);

        $deleteOffice = $auth->createPermission('delete-office');
        $deleteOffice->description = 'Delete Office';
        $auth->add($deleteOffice);

        // Izin Media Kantor
        $indexOfficeMedia = $auth->createPermission('index-officemedia');
        $indexOfficeMedia->description = 'Index Office Media';
        $auth->add($indexOfficeMedia);

        $createOfficeMedia = $auth->createPermission('create-officemedia');
        $createOfficeMedia->description = 'Create Office Media';
        $auth->add($createOfficeMedia);

        $updateOfficeMedia = $auth->createPermission('update-officemedia');
        $updateOfficeMedia->description = 'Update Office Media';
        $auth->add($updateOfficeMedia);

        $viewOfficeMedia = $auth->createPermission('view-officemedia');
        $viewOfficeMedia->description = 'View Office Media';
        $auth->add($viewOfficeMedia);

        $deleteOfficeMedia = $auth->createPermission('delete-officemedia');
        $deleteOfficeMedia->description = 'Delete Office Media';
        $auth->add($deleteOfficeMedia);

        // Izin Profil
        $indexProfile = $auth->createPermission('index-profile');
        $indexProfile->description = 'Index Profile';
        $auth->add($indexProfile);

        $createProfile = $auth->createPermission('create-profile');
        $createProfile->description = 'Create Profile';
        $auth->add($createProfile);

        // Izin Kutipan
        $indexQuote = $auth->createPermission('index-quote');
        $indexQuote->description = 'Index Quote';
        $auth->add($indexQuote);

        $createQuote = $auth->createPermission('create-quote');
        $createQuote->description = 'Create Quote';
        $auth->add($createQuote);

        $updateQuote = $auth->createPermission('update-quote');
        $updateQuote->description = 'Update Quote';
        $auth->add($updateQuote);

        $viewQuote = $auth->createPermission('view-quote');
        $viewQuote->description = 'View Quote';
        $auth->add($viewQuote);

        $deleteQuote = $auth->createPermission('delete-quote');
        $deleteQuote->description = 'Delete Quote';
        $auth->add($deleteQuote);

        // Izin Staf
        $indexStaff = $auth->createPermission('index-staff');
        $indexStaff->description = 'Index Staff';
        $auth->add($indexStaff);

        $createStaff = $auth->createPermission('create-staff');
        $createStaff->description = 'Create Staff';
        $auth->add($createStaff);

        $updateStaff = $auth->createPermission('update-staff');
        $updateStaff->description = 'Update Staff';
        $auth->add($updateStaff);

        $viewStaff = $auth->createPermission('view-staff');
        $viewStaff->description = 'View Staff';
        $auth->add($viewStaff);

        $deleteStaff = $auth->createPermission('delete-staff');
        $deleteStaff->description = 'Delete Staff';
        $auth->add($deleteStaff);

        // Izin Media Staf
        $indexStaffMedia = $auth->createPermission('index-staffmedia');
        $indexStaffMedia->description = 'Index Staff Media';
        $auth->add($indexStaffMedia);

        $createStaffMedia = $auth->createPermission('create-staffmedia');
        $createStaffMedia->description = 'Create Staff Media';
        $auth->add($createStaffMedia);

        $updateStaffMedia = $auth->createPermission('update-staffmedia');
        $updateStaffMedia->description = 'Update Staff Media';
        $auth->add($updateStaffMedia);

        $viewStaffMedia = $auth->createPermission('view-staffmedia');
        $viewStaffMedia->description = 'View Staff Media';
        $auth->add($viewStaffMedia);

        $deleteStaffMedia = $auth->createPermission('delete-staffmedia');
        $deleteStaffMedia->description = 'Delete Staff Media';
        $auth->add($deleteStaffMedia);

        // Izin Halaman
        $indexPage = $auth->createPermission('index-page');
        $indexPage->description = 'Index Page';
        $auth->add($indexPage);

        $createPage = $auth->createPermission('create-page');
        $createPage->description = 'Create Page';
        $auth->add($createPage);

        $updatePage = $auth->createPermission('update-page');
        $updatePage->description = 'Update Page';
        $auth->add($updatePage);

        $viewPage = $auth->createPermission('view-page');
        $viewPage->description = 'View Page';
        $auth->add($viewPage);

        $deletePage = $auth->createPermission('delete-page');
        $deletePage->description = 'Delete Page';
        $auth->add($deletePage);


        // Tetapkan izin ke peran (berdasarkan tx_auth_item_child.sql)

        // Admin Role Assignments
        $auth->addChild($admin, $createUserOwner);
        $auth->addChild($admin, $indexMaster);
        $auth->addChild($admin, $createMaster);
        $auth->addChild($admin, $updateMaster);
        $auth->addChild($admin, $viewMaster);
        $auth->addChild($admin, $deleteMaster);
        $auth->addChild($admin, $reportMaster);

        $auth->addChild($admin, $indexTransaction);
        $auth->addChild($admin, $createTransaction);
        $auth->addChild($admin, $updateTransaction);
        $auth->addChild($admin, $viewTransaction);
        $auth->addChild($admin, $deleteTransaction);
        $auth->addChild($admin, $reportTransaction);

        // Regular Role Assignments
        $auth->addChild($regular, $indexTransaction);
        $auth->addChild($regular, $createTransaction);
        $auth->addChild($regular, $updateTransaction);
        $auth->addChild($regular, $viewTransaction);
        $auth->addChild($regular, $deleteTransaction);
        $auth->addChild($regular, $reportTransaction);
        $auth->addChild($regular, $updateProfile);
        $auth->addChild($regular, $viewProfile);

        // Guest Role Assignments
        $auth->addChild($guest, $indexAsset);
        $auth->addChild($guest, $viewAsset);
        $auth->addChild($guest, $indexArticle);
        $auth->addChild($guest, $viewArticle);


        // Hierarki Izin (berdasarkan tx_auth_item_child.sql)
        $auth->addChild($indexMaster, $indexArticleCategory);
        $auth->addChild($createMaster, $createArticleCategory);
        $auth->addChild($updateMaster, $updateArticleCategory);
        $auth->addChild($viewMaster, $viewArticleCategory);
        $auth->addChild($deleteMaster, $deleteArticleCategory);
        $auth->addChild($reportMaster, $reportArticleCategory);

        $auth->addChild($indexMaster, $indexAssetCategory);
        $auth->addChild($createMaster, $createAssetCategory);
        $auth->addChild($updateMaster, $updateAssetCategory);
        $auth->addChild($viewMaster, $viewAssetCategory);
        $auth->addChild($deleteMaster, $deleteAssetCategory);
        $auth->addChild($reportMaster, $reportAssetCategory);

        $auth->addChild($indexMaster, $indexAuthor);
        $auth->addChild($createMaster, $createAuthor);
        $auth->addChild($updateMaster, $updateAuthor);
        $auth->addChild($viewMaster, $viewAuthor);
        $auth->addChild($deleteMaster, $deleteAuthor);

        $auth->addChild($indexMaster, $indexAuthorMedia);
        $auth->addChild($createMaster, $createAuthorMedia);
        $auth->addChild($updateMaster, $updateAuthorMedia);
        $auth->addChild($viewMaster, $viewAuthorMedia);
        $auth->addChild($deleteMaster, $deleteAuthorMedia);

        $auth->addChild($indexMaster, $indexEmployment);
        $auth->addChild($createMaster, $createEmployment);
        $auth->addChild($updateMaster, $updateEmployment);
        $auth->addChild($viewMaster, $viewEmployment);
        $auth->addChild($deleteMaster, $deleteEmployment);

        $auth->addChild($indexMaster, $indexEvent);
        $auth->addChild($createMaster, $createEvent);
        $auth->addChild($updateMaster, $updateEvent);
        $auth->addChild($viewMaster, $viewEvent);
        $auth->addChild($deleteMaster, $deleteEvent);

        $auth->addChild($indexMaster, $indexOffice);
        $auth->addChild($createMaster, $createOffice);
        $auth->addChild($updateMaster, $updateOffice);
        $auth->addChild($viewMaster, $viewOffice);
        $auth->addChild($deleteMaster, $deleteOffice);

        $auth->addChild($indexMaster, $indexOfficeMedia);
        $auth->addChild($createMaster, $createOfficeMedia);
        $auth->addChild($updateMaster, $updateOfficeMedia);
        $auth->addChild($viewMaster, $viewOfficeMedia);
        $auth->addChild($deleteMaster, $deleteOfficeMedia);

        $auth->addChild($indexMaster, $indexProfile);
        $auth->addChild($createMaster, $createProfile);
        $auth->addChild($updateMaster, $updateProfile);
        $auth->addChild($viewMaster, $viewProfile);
        $auth->addChild($deleteMaster, $deleteProfile); // Perbaikan di sini: Menggunakan $deleteProfile yang sudah dibuat

        $auth->addChild($indexMaster, $indexQuote);
        $auth->addChild($createMaster, $createQuote);
        $auth->addChild($updateMaster, $updateQuote);
        $auth->addChild($viewMaster, $viewQuote);
        $auth->addChild($deleteMaster, $deleteQuote);

        $auth->addChild($indexMaster, $indexStaff);
        $auth->addChild($createMaster, $createStaff);
        $auth->addChild($updateMaster, $updateStaff);
        $auth->addChild($viewMaster, $viewStaff);
        $auth->addChild($deleteMaster, $deleteStaff);

        $auth->addChild($indexMaster, $indexStaffMedia);
        $auth->addChild($createMaster, $createStaffMedia);
        $auth->addChild($updateMaster, $updateStaffMedia);
        $auth->addChild($viewMaster, $viewStaffMedia);
        $auth->addChild($deleteMaster, $deleteStaffMedia);

        $auth->addChild($indexMaster, $indexPage);
        $auth->addChild($createMaster, $createPage);
        $auth->addChild($updateMaster, $updatePage);
        $auth->addChild($viewMaster, $viewPage);
        $auth->addChild($deleteMaster, $deletePage);

        $auth->addChild($indexTransaction, $indexArticle);
        $auth->addChild($createTransaction, $createArticle);
        $auth->addChild($updateTransaction, $updateArticle);
        $auth->addChild($viewTransaction, $viewArticle);
        $auth->addChild($deleteTransaction, $deleteArticle);

        $auth->addChild($indexTransaction, $indexAsset);
        $auth->addChild($createTransaction, $createAsset);
        $auth->addChild($updateTransaction, $updateAsset);
        $auth->addChild($viewTransaction, $viewAsset);
        $auth->addChild($deleteTransaction, $deleteAsset);

        // Contoh penambahan yang spesifik dari file SQL Anda
        $auth->addChild($indexTransaction, $createUserRegular);


        // Tetapkan peran admin ke user_id '1'
        $auth->assign($admin, '1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = new DbManager();
        $auth->db = Yii::$app->db;

        // Hapus semua penugasan, anak, dan item RBAC
        $auth->removeAllAssignments();
        $auth->removeAllPermissions();
        $auth->removeAllRoles();
        $auth->removeAllRules();
    }
}
