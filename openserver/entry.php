<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="scriptentry.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Научно-справочная библиотека</title>
</head>

<body>
    <style>
        h3 {
            color: black;
        }

        p {
            color: black;
            text-shadow: 1px 0 1px white,
                0 1px 1px white,
                -1px 0 1px white,
                0 -1px 1px white;
            font-size: xx-large;
        }

        label {
            font-size: x-large;
            color: black;
            display: inline-block;
            width: 400px;
            text-align: right;
            white-space: nowrap;
            text-shadow: 1px 0 1px white,
                0 1px 1px white,
                -1px 0 1px white,
                0 -1px 1px white;
        }

        #preview {
            width: auto;
            height: auto;
            max-width: 500px;
            max-height: 500px;
        }

        input[type="text"] {
            width: 1000px;
            height: 30px;
        }

        input[type="submit"] {
            height: 40px;
            width: 120px;
            font-size: large;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#title').on('input', function() {
                var search = $(this).val();
                if (search != '') {
                    $.ajax({
                        url: '/vendor/search.php',
                        method: 'POST',
                        data: {
                            search: search,
                        },
                        success: function(response) {
                            $('#title_list').html(response);
                            $('#title_list').fadeIn();
                        }
                    });
                } else {
                    $('#title_list').fadeOut();
                }
            });
            $(document).on('click', '.title_item', function() {
                var title = $(this).find('.title').text();
                var id = $(this).data('id');
                $('#title').val(title);
                $('#title_list').fadeOut();
                var file = $(this).data('file');
                var author = $(this).data('author');
                var publicationtype = $(this).data('publicationtype');
                var place = $(this).data('place');
                var year = $(this).data('year');
                var publisher = $(this).data('publisher');
                var compedit = $(this).data('compedit');
                var countpages = $(this).data('countpages');
                var archive = $(this).data('archive');
                var BBK = $(this).data('bbk');
                var inventnumber = $(this).data('inventnumber');
                var numbinstances = $(this).data('numbinstances');
                var lasttaker = $(this).data('lasttaker');
                var user_id = $(this).data('user');
                if (author) {
                    $('input[name="author"]').val(author);
                }
                if (id) {
                    $('input[name="id"]').val(id);
                }
                if (publicationtype) {
                    $('select[name="publicationtype"]').val(publicationtype);
                }
                if (place) {
                    $('input[name="place"]').val(place);
                }
                if (file) {
                    var image_src = 'uploads/' + file;
                    $('#preview').attr('src', image_src);
                }
                if (year) {
                    $('input[name="year"]').val(year);
                }
                if (publisher) {
                    $('input[name="publisher"]').val(publisher);
                }
                if (user_id) {
                    $.ajax({
                        url: '/vendor/get_user_info.php',
                        method: 'POST',
                        data: {
                            user_id: user_id
                        },
                        success: function(response) {
                            var info = JSON.parse(response);
                            var familiya = info['familiya'];
                            var imya = info['imya'];
                            var otchestvo = info['otchestvo'];
                            $('#familiya').text(familiya);
                            $('#imya').text(imya);
                            $('#otchestvo').text(otchestvo);
                        }
                    });
                }
                if (compedit) {
                    $('input[name="compedit"]').val(compedit);
                }
                if (countpages) {
                    $('input[name="countpages"]').val(countpages);
                }
                if (archive) {
                    $('input[name="archive"]').val(archive);
                }
                if (BBK) {
                    $('#BBK').val(BBK);
                }
                if (inventnumber) {
                    $('input[name="inventnumber"]').val(inventnumber);
                }
                if (numbinstances) {
                    $('input[name="numbinstances"]').val(numbinstances);
                }
                if (lasttaker) {
                    $('input[name="lasttaker"]').val(lasttaker);
                }
            });
        });
    </script>
    <?php
    if (isset($_SESSION['user'])) {
        echo "<h3>" . $_SESSION['user']['login'], "," . $_SESSION['user']['role'] . ".</h3>";
    }
    ?>
    <form method="POST" action="vendor/zanes.php" enctype="multipart/form-data">
        <div style="display: flex; justify-content: center; flex-direction: column; align-items: center; text-align: center;">
            <div class="parent">
                <td>
                    <?php $image_src = empty($new_file_name) ? $row['file'] : $new_file_name; ?>
                    <img id="preview" margin="auto" onclick="openModal(this);" src="uploads/<?= $image_src ?>">
                    <br>
                    <input type="file" name="file" onchange="previewImage(this)">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Название:</label>
                <td>
                    <input type="text" name="title" id="title">
                    <input type="hidden" name="id" id="id">
                    <div id="title_list" style="text-align: center; color: #00BB00; text-shadow: 1px 0 1px white,0 1px 1px white,-1px 0 1px white,0 -1px 1px white;"></div>
                </td>
            </div>
            <br>
            <div class="label">
                <label>Тип издания:</label>
                <select name="publicationtype">
                    <option value=""></option>
                    <option value="Однотомное издание">Однотомное издание</option>
                    <option value="Многотомное издание">Многотомное издание</option>
                    <option value="Собрание сочинений">Собрание сочинений</option>
                    <option value="Периодическое издание">Периодическое издание</option>
                </select>
            </div>
            <br>
            <div class="label">
                <label>Авторы и составители:</label>
                <td>
                    <input type="text" name="author">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Под редакцией:</label>
                <td>
                    <input type="text" name="compedit">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Место:</label>
                <td>
                    <input type="text" name="place">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Год:</label>
                <td>
                    <input type="text" name="year">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Издательство:</label>
                <td>
                    <input type="text" name="publisher">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Количество страниц:</label>
                <td>
                    <input type="text" name="countpages">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Архив:</label>
                <td>
                    <input type="text" name="archive">
                </td>
            </div>
            <br>
            <div class="label">
                <label>ББК:</label>
                <td>
                    <input type="text" name="BBK" id="BBK">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Инвентарный №:</label>
                <td>
                    <input type="text" name="inventnumber">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Количество экземпляров:</label>
                <td>
                    <input type="text" name="numbinstances">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Кому выдано:</label>
                <td>
                    <input type="text" name="lasttaker">
                </td>
            </div>
            <p>Последний изменивший запись:
                <span id="user_info">
                    <span id="familiya"></span>
                    <span id="imya"></span>
                    <span id="otchestvo"></span>
                </span>
            </p>
        </div>
        <div style="display:flex; flex-direction: row; justify-content: center; align-items: center; margin-bottom: 50px; margin-top: 20px;">
            <div class="btn-group">
                <input type="submit" name="Save" value="Сохранить">
            </div>
    </form>
    <form action="mainpageoper.php">
        <div class="btn-group">
            <input type="submit" name="Back" value="Назад">
        </div>
    </form>

</body>

</html>