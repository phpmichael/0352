ALTER TABLE `form_inputs`
    ADD COLUMN `image_big_watermark` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `image_big_crop`;