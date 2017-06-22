--
--  Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions` ADD CONSTRAINT `role_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `role_permissions` ADD CONSTRAINT `role_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
--  Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions` ADD CONSTRAINT `user_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `user_permissions` ADD CONSTRAINT `user_permissions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
--  Constraints for table `user_roles`
--
ALTER TABLE `user_roles` ADD CONSTRAINT `user_roles_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `user_roles` ADD CONSTRAINT `user_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
--  Constraints for table ``
--
-- ALTER TABLE `` ADD CONSTRAINT `` FOREIGN KEY (``) REFERENCES `` (``) ON DELETE NO ACTION ON UPDATE NO ACTION;