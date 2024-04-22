<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Course</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative; 
}

h1 {
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
    font-size: 18px;
    
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea {
    width: 90%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

.back-button {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-transform: uppercase;
    font-weight: bold;
    background-color: #00CCFF;
    color: #fff;
}

.back-button:hover {
    background-color: #999;
}

.checkbox-group {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  margin-bottom: 20px;
}

.checkbox-group label {
  font-size: 16px;
  font-weight: normal;
  margin-right: 10px;
}

input[type="checkbox"] {
  float: left; 
  margin-left: 10px; 
  margin-top: 5px;
  width: 20px;
  height: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
input[readonly], textarea[readonly], select[readonly] {
        border: none; 
        background-color: transparent; 
        outline: none; 
    }
.input-group-addon{
    color: #BEBEBE;
}
.form-group label {
        margin-right: 10px;
    }
    .wtf {
        display: flex;
    }

    .start,
    .last {
        display: flex;
        align-items: center;
    }
    .start label ,
    .last label {
        margin-right: 10px;
        margin: 10px;
    }
</style>
</head>
<body>
<div class="container">
  <h1>สร้างคอร์ส</h1>
  <a href='../indextrainer.php' class='back-button'>ย้อนกลับ</a>
  <form action="process_course.php" method="POST" enctype="multipart/form-data">
    <form action="process_course.php" method="POST" enctype="multipart/form-data">
    <?php
    session_name("trainer_session");
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "trainer";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_SESSION['trainerusername'])) {
        $trainerusername = $_SESSION['trainerusername'];

        $sql = "SELECT * FROM accepted_trainers WHERE trainerusername = '$trainerusername'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
        <?php
    } else {
        echo "<script>
        window.onload = function() {
            var welcomeMessage = 'คุณไม่ใช่เทรนเนอร์จึงไม่มีสิทธิ์สร้างคอร์ส " . $_SESSION["trainerusername"] . "';
            var popup = document.createElement('div');
            popup.innerHTML = welcomeMessage;
            popup.style.backgroundColor = '#ffffff';
            popup.style.border = '1px solid #cccccc';
            popup.style.padding = '40px'; /* เพิ่ม padding เพื่อขยายขนาดของ pop-up */
            popup.style.width = '800px'; /* เพิ่มความกว้างของ pop-up */
            popup.style.height = '900px'; /* เพิ่มความสูงของ pop-up */
            popup.style.textAlign = 'center'; /* จัดข้อความให้อยู่กึ่งกลาง */
            popup.style.lineHeight = '1.5'; /* เพิ่มระยะห่างระหว่างบรรทัด */
            popup.style.borderRadius = '20px'; /* เพิ่มมุมของ pop-up */
            popup.style.boxShadow = '0px 0px 20px rgba(0, 0, 0, 0.3)'; /* เพิ่มเงาใน pop-up */
            popup.style.position = 'fixed';
            popup.style.top = '50%';
            popup.style.left = '50%';
            popup.style.transform = 'translate(-50%, -50%)';
            popup.style.zIndex = '9999';
            popup.style.fontSize = '54px'; /* เพิ่มขนาดตัวอักษร */
            
            var backButton = document.createElement('button'); // สร้างปุ่มย้อนกลับ
            backButton.textContent = 'ย้อนกลับ';
            backButton.style.padding = '10px 20px';
            backButton.style.backgroundColor = '#007bff';
            backButton.style.color = '#fff';
            backButton.style.border = 'none';
            backButton.style.borderRadius = '5px';
            backButton.style.cursor = 'pointer';
            backButton.style.marginTop = '20px'; // เพิ่มระยะห่างด้านบนของปุ่ม
            backButton.style.position = 'absolute'; // ตั้งค่าให้ปุ่มมีตำแหน่ง absolute
            backButton.style.bottom = '20px'; // ตั้งค่าให้ปุ่มอยู่ด้านล่าง
            backButton.style.left = '50%'; // ตั้งค่าให้ปุ่มอยู่กึ่งกลาง
            backButton.style.transform = 'translateX(-50%)'; // ย้ายปุ่มไปที่ตำแหน่งกึ่งกลาง
            backButton.addEventListener('click', function() {
                window.history.back(); // ให้ปุ่มย้อนกลับทำงานเมื่อคลิก
            });
            
            popup.appendChild(backButton); // เพิ่มปุ่มย้อนกลับลงใน pop-up

            document.body.appendChild(popup);

        };
    </script>";
    }
}

    $sql = "SELECT * FROM accepted_trainers WHERE trainerusername = '$trainerusername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
    <div class="form-group">
    <label for="name">ชื่อและนามสกุล:</label>
    <input type="none" name="name" placeholder="ชื่อ" value="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>" required readonly>
    </div>
    <div class="form-group">
    <label for="email">อีเมล:</label>
    <input type="email" name="email" placeholder="Email" value="<?php echo $row['emailtrainer']; ?>" required readonly>
    </div>
    <div class="form-group">
    <label for="age">อายุ:</label>
    <input type="age" name="age" placeholder="age" value="<?php echo $row['age']; ?>" required readonly>
    </div>
    <div class="form-group">
    <label for="gender">เพศ:</label>
    <input type="gender" name="gender" placeholder="Gender" value="<?php echo $row['gender']; ?>" required readonly>
    </div>
    <div class="form-group">
    <label for="phone">เบอร์:</label>
    <input type="tel" name="phone_number" placeholder="เบอร์โทรศัพท์" value="<?php echo $row['phone_number']; ?>" required readonly>
    </div>
    <input type="hidden" name="trainer_id" value="<?php echo $row['trainer_id']; ?>" required readonly >
    <input type="hidden" name="trainerusername" value="<?php echo $row['trainerusername']; ?>" required readonly >
    <?php
    } else {
    ?>
    <?php
    }
    ?>
    <div class="form-group">
        <label for="title">ชื่อคอร์ส:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="price">ราคาต่อคอร์ส:</label>
        <input type="number" id="price" name="price" min="0" step="any" required>
        <span class="input-group-addon">ราคา</span>
    </div>
    <div class="form-group">
    <label for="duration">ระยะเวลา (ชม.):</label>
        <input type="number" id="duration" name="duration" min="1" required>
        <span class="input-group-addon">ชั่วโมง</span>
    </div>
    <div class="form-group">
    <label for="start_date">วันที่เริ่มต้นของคอร์ส:</label>
    <input type="text" id="start_date" name="start_date" placeholder="เลือกวันที่เริ่มต้นของคอร์ส">
    </div>

    <div class="form-group">
    <label for="end_date">วันที่สิ้นสุดของคอร์ส:</label>
    <input type="text" id="end_date" name="end_date" placeholder="เลือกวันที่สิ้นสุดของคอร์ส">
    </div>
    <div class="wtf">
    <div class="start">
        <label for="time_start">เวลาเริ่ม:</label>
        <input type="time" id="start_time" name="start_time" required>
    </div>
    <div class="last">
        <label for="time_end">ถึง:</label>
        <input type="time" id="end_time" name="end_time" required>
    </div>
</div>
    <div class="form-group">
    <label for="difficulty">ความยาก:</label>
    <select id="difficulty" name="difficulty" required>
        <option value="very_easy">ง่ายสุด</option>
        <option value="easy">ง่าย</option>
        <option value="medium">ปานกลาง</option>
        <option value="hard">ยาก</option>
        <option value="very_hard">ยากที่สุด</option>
    </select>
    <p id="difficulty_description"></p>
    </div>
    <div class="form-group">
    <label for="description">คำอธิบาย:</label>
    <textarea id="description" name="description" rows="4" maxlength="300" required></textarea>
    </div>

    <div class="checkbox-group">
    <label for="activity1">
                <input type="checkbox" id="activity1" name="activity[]" value="1"> เต้นแอโรบิก
            </label>
            <label for="activity2">
                <input type="checkbox" id="activity2" name="activity[]" value="2"> การฝึกป้องกันตัว
            </label>
            <label for="activity3">
                <input type="checkbox" id="activity3" name="activity[]" value="3"> บอดี้เวท
            </label>
            <label for="activity4">
                <input type="checkbox" id="activity4" name="activity[]" value="4"> เวทเทรนนิ่ง
            </label>
            <label for="activity5">
                <input type="checkbox" id="activity5" name="activity[]" value="5"> การโยคะ
            </label>
            <label for="activity6">
                <input type="checkbox" id="activity6" name="activity[]" value="6"> คาดิโอ
            </label>
            <label for="activity7">
                <input type="checkbox" id="activity7" name="activity[]" value="7"> ลดน้ำหนัก
            </label>
            <label for="activity8">
                <input type="checkbox" id="activity8" name="activity[]" value="8"> การสร้างกล้ามเนื้อ
            </label>
            <label for="activity9">
                <input type="checkbox" id="activity9" name="activity[]" value="9"> การฝึกกลุ่ม
            </label>
            <label for="activity10">
                <input type="checkbox" id="activity10" name="activity[]" value="10"> การฝึกออนไลน์
            </label>
            <label for="activity11">
                <input type="checkbox" id="activity11" name="activity[]" value="11"> เพิ่มน้ำหนัก
            </label>
            <label for="activity15">
            <input type="checkbox" id="activity15" name="activity[]" value="12"> การฝึกออนไซต์
            </label>
    <div class="form-group">
      <label for="cover_image">รูปปกคอร์ส:</label>
      <input type="file" id="cover_image" name="cover_image" accept="image/*" required>
    </div>
    <button type="submit">สร้างคอร์ส</button>
  </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script>
    const difficultyDescriptions = {
  'very_easy': 'ง่ายสุด: เหมาะสำหรับผู้เริ่มต้นที่ไม่มีประสบการณ์',
  'easy': 'ง่าย: เหมาะสำหรับผู้ที่มีความรู้เบื้องต้น',
  'medium': 'ปานกลาง: เหมาะสำหรับผู้ที่มีประสบการณ์ในระดับกลาง',
  'hard': 'ยาก: เหมาะสำหรับผู้ที่มีความชำนาญและมีความรู้ลึก',
  'very_hard': 'ยากที่สุด: เหมาะสำหรับผู้ที่มีความเชี่ยวชาญและมีประสบการณ์มาก'
};

// เพิ่มการจัดการเหตุการณ์ change สำหรับ select element
document.getElementById('difficulty').addEventListener('change', function() {
  const selectedDifficulty = this.value;
  const difficultyDescriptionElement = document.getElementById('difficulty_description');
  difficultyDescriptionElement.textContent = difficultyDescriptions[selectedDifficulty];
});

document.getElementById('start_time').addEventListener('change', function() {
    const startTime = this.value; // เวลาที่เลือกใน start_time
    const endTime = document.getElementById('end_time').value; // เวลาที่เลือกใน end_time

    // เช็คเงื่อนไขเวลาที่เลือกใน end_time ว่าน้อยกว่า start_time หรือไม่
    if (endTime < startTime) {
        alert('เวลาที่สิ้นสุดต้องมากกว่าหรือเท่ากับเวลาที่เริ่ม');
        document.getElementById('end_time').value = ''; // ล้างค่าใน end_time
    }
});

// เมื่อมีการเปลี่ยนแปลงใน end_time
document.getElementById('end_time').addEventListener('change', function() {
    const startTime = document.getElementById('start_time').value; // เวลาที่เลือกใน start_time
    const endTime = this.value; // เวลาที่เลือกใน end_time

    // เช็คเงื่อนไขเวลาที่เลือกใน end_time ว่าน้อยกว่า start_time หรือไม่
    if (endTime < startTime) {
        alert('เวลาที่สิ้นสุดต้องมากกว่าหรือเท่ากับเวลาที่เริ่ม');
        this.value = ''; // ล้างค่าใน end_time
    }
});

var startDatePicker = new Pikaday({
    field: document.getElementById('start_date'),
    minDate: new Date(),
    format: 'DD/MM/YYYY',
    onSelect: function(selectedDate) {
        endDatePicker.setMinDate(selectedDate); // กำหนดวันที่ต่ำสุดใหม่สำหรับ end_date เมื่อเลือกวันที่ใน start_date
    },
    i18n: {
        previousMonth: 'ก่อนหน้า',
        nextMonth: 'ถัดไป',
        months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        weekdays: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        today: 'วันนี้',
        clear: 'ล้าง',
        done: 'เสร็จสิ้น'
    }
});

var endDatePicker = new Pikaday({
    field: document.getElementById('end_date'),
    minDate: new Date(),
    format: 'DD/MM/YYYY',
    i18n: {
        previousMonth: 'ก่อนหน้า',
        nextMonth: 'ถัดไป',
        months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        weekdays: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        today: 'วันนี้',
        clear: 'ล้าง',
        done: 'เสร็จสิ้น'
    }
});
        var selectedCheckboxes = 0;

        function checkSelectedCheckbox() {
            var checkboxes = document.querySelectorAll('input[name="activity[]"]:checked');
            selectedCheckboxes = checkboxes.length;
        }

        document.querySelectorAll('input[name="activity[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('click', function() {
                checkSelectedCheckbox();
                if (selectedCheckboxes > 3) {
                    this.checked = false;
                    checkSelectedCheckbox();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
        var descriptionInput = document.getElementById('description');
        var characterCount = document.createElement('div');
        characterCount.textContent = '0/300';
        descriptionInput.parentNode.appendChild(characterCount);

        descriptionInput.addEventListener('input', function() {
            var currentLength = descriptionInput.value.length;
            characterCount.textContent = currentLength + '/300';
        });
    });
    </script>
</body>
</html>
