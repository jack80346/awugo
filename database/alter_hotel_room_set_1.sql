ALTER TABLE `hotel_room_set`
ADD COLUMN `show_last_year`  tinyint(1) NULL DEFAULT 1 COMMENT '顯示去年的區間設定' AFTER `room_type`;

