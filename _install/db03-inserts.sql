--
-- Inserts for table 'permissions'
--
INSERT INTO `permissions` (`id`, `name`) VALUES
    (1, 'Create Users'),
    (2, 'Delete Users'),
    (3, 'Update Users'),
    (4, 'View Admin Pages'),
    (5, 'Create Admin Users'),
    (6, 'Delete Admin Users'),
    (7, 'Update Admin Users');
    
--
-- Inserts for table 'roles'
--
INSERT INTO `roles` (`id`, `name`) VALUES
    (1, 'Admin'),
    (2, 'Super Admin');

--
-- Inserts for table 'role_permissions'
--
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
    (1, 1, 1),
    (2, 1, 2),
    (3, 1, 3),
    (4, 1, 4),
    (5, 2, 5),
    (6, 2, 6),
    (7, 2, 7);

--
-- Inserts for table 'users'
--
INSERT INTO `users` (`id`, `activated`, `email`, `forename`, `password`, `salt`, `surname`, `username`) VALUES
    (1, true, 'admin@mail.com', 'Andrew', 'ea2959d87ea2974afcd45c6224d2e5322bc349db8e65f8a3c7460e2a8fb9a883', '>TrKAx^/<E^+aX!-5K|}pL!Po9(gH_Fr', 'Dyer', 'admin');

--
-- Inserts for table 'user_roles'
--
INSERT INTO `user_roles` (`id`, `role_id`, `user_id`) VALUES
    (1, 1, 1),
    (2, 2, 1);