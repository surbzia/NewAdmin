<?php

use App\Models\Variant;

if(!function_exists('getVarientID')){
    function getVarientID($sku)
    {
        return Variant::where('sku', $sku)->first()->id;
    }
}

if(!function_exists('getDefaultPermissions')){
    function getDefaultPermissions()
    {
       return "insert into permissions (id,name,title,updated_at,created_at) values
            (1, 'users-list', 'Users Listing', '2022-01-25 19:17:41', '2021-10-12 12:36:14'),
            (2, 'users-create', 'Users Create', '2022-01-25 19:17:47', '2021-10-12 12:36:14'),
            (3, 'users-edit', 'Users Edit', '2022-01-25 19:17:53', '2021-10-12 12:36:38'),
            (4, 'users-delete', 'Users Delete', '2022-01-25 19:17:58', '2021-10-12 12:36:38'),
            (5, 'users-view', 'Users View', '2022-01-25 19:18:03', '2021-10-12 12:36:59'),
            (56, 'role-list', 'Role List', '2022-01-25 21:33:06', '2022-01-25 21:33:06'),
            (57, 'role-create', 'Role Create', '2022-01-25 21:33:12', '2022-01-25 21:33:09'),
            (58, 'role-edit', 'Role Edit', '2022-01-25 21:33:18', '2022-01-25 21:33:15'),
            (59, 'role-delete', 'Role Delete', '2022-01-25 21:33:26', '2022-01-25 21:33:22'),
            (60, 'role-view', 'Role View', '2022-01-25 21:33:33', '2022-01-25 21:33:30'),
            (61, 'permission-list', 'Permission List', '2022-01-25 23:02:08', '2022-01-25 23:02:08'),
            (62, 'permission-create', 'Permission Create', '2022-01-25 23:02:20', '2022-01-25 23:02:12'),
            (63, 'permission-edit', 'Permission Edit', '2022-01-25 23:02:27', '2022-01-25 23:02:23'),
            (64, 'permission-delete', 'Permission Delete', '2022-01-25 23:02:34', '2022-01-25 23:02:29'),
            (65, 'permission-view', 'Permission View', '2022-01-25 23:30:13', '2022-01-25 23:02:36'),
            (93, 'product-list', 'Product List', '2022-01-26 19:02:49', '2022-01-26 19:02:49'),
            (94, 'product-view', 'Product View', '2022-01-26 19:02:59', '2022-01-26 19:02:59'),
            (95, 'product-create', 'Product Create', '2022-01-26 19:03:10', '2022-01-26 19:03:10'),
            (96, 'product-edit', 'Product Edit', '2022-01-26 19:03:16', '2022-01-26 19:03:16'),
            (97, 'product-delete', 'Product Delete', '2022-01-26 19:03:26', '2022-01-26 19:03:26'),
            (113, 'coupon-list', 'Coupon List', '2022-02-23 15:59:08', '2022-02-23 15:59:08'),
            (114, 'coupon-create', 'Coupon Create', '2022-02-23 15:59:27', '2022-02-23 15:59:27'),
            (115, 'coupon-edit', 'Coupon Edit', '2022-02-23 15:59:38', '2022-02-23 15:59:38'),
            (116, 'coupon-delete', 'Coupon Delete', '2022-02-23 15:59:47', '2022-02-23 15:59:47'),
            (117, 'coupon-view', 'Coupon View', '2022-02-23 15:59:59', '2022-02-23 15:59:59'),
            (128, 'wishlistlist', 'WishlistList', '2022-02-23 16:50:57', '2022-02-23 16:50:57'),
            (129, 'wishlistview', 'WishlistView', '2022-02-23 16:50:58', '2022-02-23 16:50:58'),
            (130, 'wishlistcreate', 'WishlistCreate', '2022-02-23 16:50:58', '2022-02-23 16:50:58'),
            (131, 'wishlistedit', 'WishlistEdit', '2022-02-23 16:50:58', '2022-02-23 16:50:58'),
            (132, 'wishlistdelete', 'WishlistDelete', '2022-02-23 16:50:58', '2022-02-23 16:50:58'),
            (133, 'category-list', 'Category List', '2022-03-01 00:24:46', '2022-03-01 00:24:46'),
            (134, 'category-view', 'Category View', '2022-03-01 00:24:46', '2022-03-01 00:24:46'),
            (135, 'category-create', 'Category Create', '2022-03-01 00:24:46', '2022-03-01 00:24:46'),
            (136, 'category-edit', 'Category Edit', '2022-03-01 00:24:46', '2022-03-01 00:24:46'),
            (137, 'category-delete', 'Category Delete', '2022-03-01 00:24:46', '2022-03-01 00:24:46'),
            (138, 'brand-list', 'Brand List', '2022-03-04 05:13:10', '2022-03-04 05:13:10'),
            (139, 'brand-view', 'Brand View', '2022-03-04 05:13:10', '2022-03-04 05:13:10'),
            (140, 'brand-create', 'Brand Create', '2022-03-04 05:13:10', '2022-03-04 05:13:10'),
            (141, 'brand-edit', 'Brand Edit', '2022-03-04 05:13:10', '2022-03-04 05:13:10'),
            (142, 'brand-delete', 'Brand Delete', '2022-03-04 05:13:10', '2022-03-04 05:13:10'),
            (143, 'productquote-list', 'ProductQuote List', '2022-03-04 09:17:54', '2022-03-04 09:17:54'),
            (144, 'productquote-view', 'ProductQuote View', '2022-03-04 09:17:54', '2022-03-04 09:17:54'),
            (147, 'productquote-delete', 'ProductQuote Delete', '2022-03-04 09:17:54', '2022-03-04 09:17:54'),
            (153, 'banner-list', 'Banner List', '2022-03-07 03:10:25', '2022-03-07 03:10:25'),
            (154, 'banner-view', 'Banner View', '2022-03-07 03:10:25', '2022-03-07 03:10:25'),
            (155, 'banner-create', 'Banner Create', '2022-03-07 03:10:25', '2022-03-07 03:10:25'),
            (156, 'banner-edit', 'Banner Edit', '2022-03-07 03:10:25', '2022-03-07 03:10:25'),
            (157, 'banner-delete', 'Banner Delete', '2022-03-07 03:10:25', '2022-03-07 03:10:25'),
            (158, 'upload-product-csv', 'Upload Product CSV', '2022-03-07 08:52:55', '2022-03-07 08:52:55'),
            (159, 'order-list', 'Order List', '2022-03-10 08:07:57', '2022-03-10 08:07:57'),
            (160, 'order-view', 'Order View', '2022-03-10 08:08:09', '2022-03-10 08:08:09'),
            (161, 'order-status-handle', 'Order Status Handle', '2022-03-10 08:08:21', '2022-03-10 08:08:21'),
            (162, 'order-payment-charge', 'Order Payment Charge', '2022-03-10 08:08:32', '2022-03-10 08:08:32'),
            (163, 'country-list', 'Country List', '2022-03-10 08:32:01', '2022-03-10 08:32:01'),
            (164, 'country-view', 'Country View', '2022-03-10 08:32:01', '2022-03-10 08:32:01'),
            (165, 'country-create', 'Country Create', '2022-03-10 08:32:01', '2022-03-10 08:32:01'),
            (166, 'country-edit', 'Country Edit', '2022-03-10 08:32:01', '2022-03-10 08:32:01'),
            (167, 'country-delete', 'Country Delete', '2022-03-10 08:32:01', '2022-03-10 08:32:01'),
            (168, 'state-list', 'State List', '2022-03-10 09:22:01', '2022-03-10 09:22:01'),
            (169, 'state-view', 'State View', '2022-03-10 09:22:01', '2022-03-10 09:22:01'),
            (170, 'state-create', 'State Create', '2022-03-10 09:22:01', '2022-03-10 09:22:01'),
            (171, 'state-edit', 'State Edit', '2022-03-10 09:22:01', '2022-03-10 09:22:01'),
            (172, 'state-delete', 'State Delete', '2022-03-10 09:22:01', '2022-03-10 09:22:01'),
            (173, 'city-list', 'City List', '2022-03-10 09:44:36', '2022-03-10 09:44:36'),
            (174, 'city-view', 'City View', '2022-03-10 09:44:36', '2022-03-10 09:44:36'),
            (175, 'city-create', 'City Create', '2022-03-10 09:44:36', '2022-03-10 09:44:36'),
            (176, 'city-edit', 'City Edit', '2022-03-10 09:44:36', '2022-03-10 09:44:36'),
            (177, 'city-delete', 'City Delete', '2022-03-10 09:44:37', '2022-03-10 09:44:37'),
            (178, 'exemption-list', 'Exemption List', '2022-03-15 13:55:39', '2022-03-15 13:55:39'),
            (179, 'exemption-view', 'Exemption View', '2022-03-15 13:55:39', '2022-03-15 13:55:39'),
            (180, 'exemption-create', 'Exemption Create', '2022-03-15 13:55:39', '2022-03-15 13:55:39'),
            (181, 'exemption-edit', 'Exemption Edit', '2022-03-15 13:55:39', '2022-03-15 13:55:39'),
            (182, 'exemption-delete', 'Exemption Delete', '2022-03-15 13:55:39', '2022-03-15 13:55:39');";
    }
}
