ALTER TABLE `hotel_room_set`
ADD COLUMN `continuous_sale`  int NULL DEFAULT 0 COMMENT '若連續住宿，第2天以後房價優惠折數%' AFTER `show_last_year`,
ADD COLUMN `weekday_checkin`  time NULL DEFAULT NULL COMMENT '平日入住時間' AFTER `continuous_sale`,
ADD COLUMN `weekday_checkout`  time NULL DEFAULT NULL COMMENT '平日退房時間' AFTER `weekday_checkin`,
ADD COLUMN `holiday_checkin`  time NULL DEFAULT NULL COMMENT '假日入住時間' AFTER `weekday_checkout`,
ADD COLUMN `holiday_checkout`  time NULL DEFAULT NULL COMMENT '假日退房時間' AFTER `holiday_checkin`;