CREATE TABLE `quiz_questions_copies` (
  `orig_id` INT(10) UNSIGNED NOT NULL,
  `copy_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`orig_id`, `copy_id`)
)
ENGINE=MyISAM;