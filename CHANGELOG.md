# Changelog


## 3.0.0.beta.0

- **PHP**:
  - Started using **OOP**;
  - PHP has been rewritten using **MVC** software design pattern;
  - Whole backend files are in `./App/` folder;
- Fixed some small mistakes.

## 2.4.0

- Added irregular translation exercises type;
- Improved `special_signs.js` file to can be use in irregular translations.

## 2.3.8

- Regarding **JavaScript** files: 
  - Added map exercises written using **OOP** (`exercise-utils.js`, `map-model.js`, `map-app.js`)
  - Translation exercise prescribed using **OOP** (`exercise-utils.js`, `translation-model.js`, `translation-app.js`)
  - *fetch()* instruction in `fetch_data.js` has changed form *.then()* chain to *async*/*await*
  - Improved `reveal_sticky_header.js` to *header* not be hidden on window resize
  - All scripts are `type="module"` 
- Regarding **CSS** files:
  - Added `map.css` file to style map exercises
  - Max website width in `style.css` hes been changed form 1000px to 1200px
- Regarding **PHP** files:
  - Begun used shorter syntax:
    ```PHP
    <?= /* content */ ?>
    ```
    instead of:
    ```PHP
    <?php echo /* content */ ?>
    ```
  - Begun used more readable syntax:
    ```HTML
    ?>
    <!-- HTML CONTENT -->
    <?php
    ```
    instead of:
    ```PHP
    <?php 
    echo <<< EOD
      <!-- HTML CONTENT -->
    EOD
    ?>
    ```
  - `get-data.php`
    - Improved script operation changing *while* loop to *fetch_all()* method
    - Added support for map exercises
  - `index.php` is more readable using better variable names and better SQL query notation
  - `conn-data.php` file now returns associated array of data instead of creating variable *$cd* 
- SQL:
  - Database table is more readable using first letter upper case like *Name*, *Type*, *ID*
- Other files:
  - Added maps images

## 2.2.1-beta.0

- Added functionality to hamburger menu (drop-down)

## 2.1.2-beta.2

- Improved special signs for touch devices

## 2.1.2-beta.1

- Added special signs buttons (like ä ö ü ß)

## 2.0.3-beta.2

- Improved styles

## 2.0.3-beta.1

- Added stats (correct, incorrect and streak)
- Fixed hint button and skip button
- Added `cursor: wait;` on translation section when is fetching data

## 2.0.1-beta.1

- functions separated from `index.php` to 
  - `content.php`
  - `exercises.php`
  - `footer.php`
  - `header.php`
- Added `about-us.php` file instead of an empty `o-nas.html` file
- Added *RewriteRule* to the `about-us.php` file
- Cosmetic changes to `style.css` and `README.md` + deleted **?>** from end of all `PHP` files

## 2.0.0-beta.2

- Added README.md and CHANGELOG.md (and screenshots) to the repository.
- Fixed version identifier in footer.

## 2.0.0-beta.1

- the application was partially rewritten from version "1.3v" (the entire application logic was implemented on the client side) to PHP and translation data was entered into the database.