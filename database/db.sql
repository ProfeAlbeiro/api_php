CREATE DATABASE DB;
USE DB;

CREATE TABLE locations (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    city VARCHAR(255),
    state VARCHAR(20),
    photo VARCHAR(255),
    availableUnits INT,
    wifi BOOLEAN,
    laundry BOOLEAN
);

INSERT INTO locations (id, name, city, state, photo, availableUnits, wifi, laundry) VALUES
(0, 'Acme Fresh Start Housing', 'Chicago', 'IL', 'https://angular.dev/assets/images/tutorials/common/bernard-hermant-CLKGGwIBTaY-unsplash.jpg', 4, true, true),
(1, 'A113 Transitional Housing', 'Santa Monica', 'CA', 'https://angular.dev/assets/images/tutorials/common/brandon-griggs-wR11KBaB86U-unsplash.jpg', 0, false, true),
(2, 'Warm Beds Housing Support', 'Juneau', 'AK', 'https://angular.dev/assets/images/tutorials/common/i-do-nothing-but-love-lAyXdl1-Wmc-unsplash.jpg', 1, false, false),
(3, 'Homesteady Housing', 'Chicago', 'IL', 'https://angular.dev/assets/images/tutorials/common/ian-macdonald-W8z6aiwfi1E-unsplash.jpg', 1, true, false),
(4, 'Happy Homes Group', 'Gary', 'IN', 'https://angular.dev/assets/images/tutorials/common/krzysztof-hepner-978RAXoXnH4-unsplash.jpg', 1, true, false),
(5, 'Hopeful Apartment Group', 'Oakland', 'CA', 'https://angular.dev/assets/images/tutorials/common/r-architecture-JvQ0Q5IkeMM-unsplash.jpg', 2, true, true),
(6, 'Seriously Safe Towns', 'Oakland', 'CA', 'https://angular.dev/assets/images/tutorials/common/phil-hearing-IYfp2Ixe9nM-unsplash.jpg', 5, true, true),
(7, 'Hopeful Housing Solutions', 'Oakland', 'CA', 'https://angular.dev/assets/images/tutorials/common/r-architecture-GGupkreKwxA-unsplash.jpg', 2, true, true),
(8, 'Seriously Safe Towns', 'Oakland', 'CA', 'https://angular.dev/assets/images/tutorials/common/saru-robert-9rP3mxf8qWI-unsplash.jpg', 10, false, false),
(9, 'Capital Safe Towns', 'Portland', 'OR', 'https://angular.dev/assets/images/tutorials/common/webaliser-_TPTXZd9mOo-unsplash.jpg', 6, true, true);