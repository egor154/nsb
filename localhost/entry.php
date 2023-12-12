<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="32x32" href="android-chrome-512x512.png">
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
            font-size: 60px;
        }

        p {
            color: black;
            text-shadow: 1px 0 1px white,
                0 1px 1px white,
                -1px 0 1px white,
                0 -1px 1px white;
            font-size: x-large;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .modal-buttons {
            margin-top: 10px;
        }

        .modal-buttons button {
            font-size: 16px;
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
                var BBK = $(this).data('bbk');
                var UDK = $(this).data('udk');
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
                if (compedit) {
                    $('input[name="compedit"]').val(compedit);
                }
                if (countpages) {
                    $('input[name="countpages"]').val(countpages);
                }
                if (BBK) {
                    $('input[name="BBK"]').val(BBK);
                }
                if (UDK) {
                    $('input[name="UDK"]').val(UDK);
                }
            });
        });
        /* скрипт на клик по архиву с последующим выводом из additional_info значений inventnumber и numbinstances конкретного печатного издания */
        function getAdditionalInfo() {
            var selectedArchive = document.getElementById("archive").value;
            var id = document.getElementById("id").value;
            if (selectedArchive != '') {
                $.ajax({
                    url: '/vendor/get_additional_info.php',
                    method: 'POST',
                    data: {
                        archive: selectedArchive,
                        id: id
                    },
                    success: function(response) {
                        var info = JSON.parse(response);
                        var inventnumber = info['inventnumber'];
                        var numbinstances = info['numbinstances'];
                        var familiya = info['familiya'];
                        var imya = info['imya'];
                        var otchestvo = info['otchestvo'];
                        $('#familiya').text(familiya);
                        $('#imya').text(imya);
                        $('#otchestvo').text(otchestvo);
                        $('#inventnumber').val(inventnumber);
                        $('#numbinstances').val(numbinstances);
                    }
                });
            } else {
                // Очистить информацию о последнем изменившем запись
                $('#familiya').text('');
                $('#imya').text('');
                $('#otchestvo').text('');
                $('#inventnumber').val('');
                $('#numbinstances').val('');
            }
        }
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
                    <div id="title_list" style="text-align: center; color: #00BB00; text-shadow: 1px 0 1px white,0 1px 1px white,-1px 0 1px white,0 -1px 1px white;">
                    </div>
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
                <label>ББК:</label>
                <td>
                    <input type="text" name="BBK" id="BBK">
                </td>
            </div>
            <br>
            <div class="label">
                <label>УДК:</label>
                <td>
                    <input type="text" name="UDK" id="UDK">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Архив:</label>
                <td>
                    <select name="archive" id="archive" onchange="getAdditionalInfo()">
                        <option value=""></option>
                        <option value="ГКУ &quot;ЦГА УР&quot;">ГКУ &quot;ЦГА УР&quot;</option>
                        <option value="Филиал ГКУ ЦГА УР &quot;ГАОПИ&quot;">Филиал ГКУ ЦГА УР &quot;ГАОПИ&quot;</option>
                    </select>
                </td>
            </div>
            <br>
            <div class="label">
                <label>Инвентарный №:</label>
                <td>
                    <input type="text" name="inventnumber" id="inventnumber">
                </td>
            </div>
            <br>
            <div class="label">
                <label>Количество экземпляров:</label>
                <td>
                    <input type="text" name="numbinstances" id="numbinstances">
                </td>
            </div>
            <br>
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
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p style="font-size:xx-large;">Вы уверены, что хотите удалить запись из БД Научно-справочная библиотека?</p>
            <div class="modal-buttons">
                <button onclick="deleteRecord()" style="width: 150px; height: 50px">Да</button>
                <button onclick="closeModal()" style="width: 150px; height: 50px">Нет</button>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            document.getElementById("confirmModal").style.display = "block";
            var id = document.getElementsByName("id")[0].value;
            document.getElementById("deleteForm").setAttribute("action", "vendor/delete.php?id=" + id);
        }

        function deleteRecord() {
            var id = document.getElementsByName("id")[0].value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "vendor/delete.php?id=" + id, true);
            xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send();
            closeModal();
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }
    </script>
    <form id="deleteForm" action="" method="POST" onsubmit="confirmDelete(event);">
        <div class="btn-group">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="submit" name="delete" value="Удалить">
        </div>
    </form>
    <form action="mainpageoper.php">
        <div class="btn-group">
            <input type="submit" name="Back" value="Назад">
        </div>
    </form>
    </div>
</body>

</html>