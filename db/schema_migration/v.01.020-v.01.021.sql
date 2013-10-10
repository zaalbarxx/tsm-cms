ALTER TABLE tsm_reg_families ADD COLUMN password_reset_token VARCHAR(128);
ALTER TABLE tsm_reg_families ADD COLUMN password_reset_expire TIMESTAMP;