<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background: url("assist/Background3.png");
            background-attachment: fixed;
            margin: 0;
        }

        .wrapper {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            font-size: 16px;
        }

        .input-box {
            margin-bottom: 20px;
        }

        .input-box p {
            margin: 5px 0;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="number"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            font-size: 0.8em;
            color: #666;
        }

        table {
            width: 100%;
        }

        th {
            font-size: 16px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th:first-child,
        td:first-child {
            width: 65%;
        }

        th:not(:first-child),
        td:not(:first-child) {
            width: 15%;
        }

        button {
            padding: 17px 40px;
            border-radius: 50px;
            cursor: pointer;
            border: 0;
            color: #fff;
            background-color: #2F2D68;
            border: 3px solid #312CA6;
            box-shadow: rgb(0 0 0 / 5%) 0 0 8px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-size: 15px;
            transition: all 0.5s ease;
            display: block;
            margin: 0 auto; 
        }

        button:hover {
            letter-spacing: 3px;
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
        }

        button:active {
            letter-spacing: 3px;
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 0px 0px 0px;
            transform: translateY(10px);
            transition: 100ms;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none;
        }

        .custumflie {
            border: 2px solid #6C22A6;
            border-radius: 45px;
            padding: 2px;
            font-size: 18px;
        }

        .custumflie::-webkit-file-upload-button {
            background-image: linear-gradient(45deg, #1D24CA, #6C22A6);
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }
        .pic  img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
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
        <div class="wrapper">
        <button onclick="window.location.href='trainer.php';" style="position: fixed; bottom: 20px; right: 20px; padding: 17px 40px; border-radius: 50px; cursor: pointer; border: 0; color: #fff; background-color: #2F2D68; border: 3px solid #312CA6; box-shadow: rgb(0 0 0 / 5%) 0 0 8px; letter-spacing: 1.5px; text-transform: uppercase; font-size: 15px; transition: all 0.5s ease;">ย้อนกลับ</button>
            <i class='bx bxs-x-square' style='color:#ff0000'></i>
            <h1>แก้ไขโปรไฟล์</h1>
            <form action="update_profiletrainer.php" method="POST" enctype="multipart/form-data">

                <div class="input-box">
                    <p>ประวัติส่วนตัว</p>
                    <label>รูปโปรไฟล์:</label>
                    <div class='pic'>
                        <?php
                        if (!empty($row['image_profile'])) {
                            echo "<img src='" . $row['image_profile'] . "'>";
                        }
                        ?>
                    </div>
                <input type="text" name="first_name" placeholder="ชื่อ" value="<?php echo $row['first_name']; ?>" required>
                <input type="text" name="last_name" placeholder="นามสกุล" value="<?php echo $row['last_name']; ?>" required>
                <input type="email" name="emailtrainer" placeholder="Email" value="<?php echo $row['emailtrainer']; ?>" required>
                <input type="tel" name="phone_number" placeholder="เบอร์โทรศัพท์" maxlength="10" value="<?php echo $row['phone_number']; ?>" required>
            <div class="input-radio">
            <label for="gender">เพศ:</label>
            <select id="gender" name="gender" required>
                <option value="ชาย">ชาย</option>
                <option value="หญิง">หญิง</option> 
                <option value="อื่นๆ">อื่นๆ</option>
            </select>
            <div class="input-box">
                <p>สถานการศึกษา</p>
                <table>
                    <tr>
                        <th>ระดับการศึกษา</th>
                        <th>ตั้งแต่</th>
                        <th>ถึง</th>
                    </tr>
                    <tr class="education-group">
                <td><input type="text" name="level_2" class="education1" placeholder="ปวช." value="<?php echo $row['level_2']; ?>"></td>
                <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                    type="number" name="start_year_2" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['start_year_2']; ?>"></td>
                <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                    type="number" name="end_year_2" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['end_year_2']; ?>"></td>
                </tr>

                <tr class="education-group">
                    <td><input type="text" name="level_3" class="education1" placeholder="ปวส." value="<?php echo $row['level_3']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_3" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['start_year_3']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="end_year_3" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['end_year_3']; ?>"></td>
                </tr>

                <tr class="education-group">
                    <td><input type="text" name="level_4" class="education1" placeholder="ปริญญาตรี" value="<?php echo $row['level_4']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_4" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['start_year_4']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="end_year_4" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['end_year_4']; ?>"></td>
                </tr>

                <tr class="education-group">
                    <td><input type="text" name="level_5" class="education1" placeholder="สูงกว่าปริญญาตรี" value="<?php echo $row['level_5']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_5" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['start_year_5']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="end_year_5" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['end_year_5']; ?>"></td>
                </tr>

                <tr class="education-group">
                    <td><input type="text" name="level_6" class="education1" placeholder="อื่น ๆ" value="<?php echo $row['level_6']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_6" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['start_year_6']; ?>"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="end_year_6" class="education" placeholder="พ.ศ." maxlength="4" value="<?php echo $row['end_year_6']; ?>"></td>
                </tr>
                </table>
            </div>

            <div class="input-box">
                <p>ที่อยู่ในกรุงเทพมหาคร</p>
                <label for="district">เลือกเขต:</label>
    <select id="district" name="district" onchange="updateSubdistricts()">
    <option value="เขตพระนคร">เขตพระนคร</option>
    <option value="เขตดุสิต">เขตดุสิต</option>
    <option value="เขตหนองจอก">เขตหนองจอก</option>
    <option value="เขตบางรัก">เขตบางรัก</option>
    <option value="เขตบางเขน">เขตบางเขน</option>
    <option value="เขตบางกะปิ">เขตบางกะปิ</option>
    <option value="เขตปทุมวัน">เขตปทุมวัน</option>
    <option value="เขตป้อมปราบศัตรูพ่าย">เขตป้อมปราบศัตรูพ่าย</option>
    <option value="เขตพระโขนง">เขตพระโขนง</option>
    <option value="เขตมีนบุรี">เขตมีนบุรี</option>
    <option value="เขตลาดกระบัง">เขตลาดกระบัง</option>
    <option value="เขตยานนาวา">เขตยานนาวา</option>
    <option value="เขตสัมพันธวงศ์">เขตสัมพันธวงศ์</option>
    <option value="เขตพญาไท">เขตพญาไท</option>
    <option value="เขตธนบุรี">เขตธนบุรี</option>
    <option value="เขตบางกอกใหญ่">เขตบางกอกใหญ่</option>
    <option value="เขตห้วยขวาง">เขตห้วยขวาง</option>
    <option value="เขตคลองสาน">เขตคลองสาน</option>
    <option value="เขตตลิ่งชัน">เขตตลิ่งชัน</option>
    <option value="เขตบางกอกน้อย">เขตบางกอกน้อย</option>
    <option value="เขตบางขุนเทียน">เขตบางขุนเทียน</option>
    <option value="เขตภาษีเจริญ">เขตภาษีเจริญ</option>
    <option value="เขตหนองแขม">เขตหนองแขม</option>
    <option value="เขตราษฎร์บูรณะ">เขตราษฎร์บูรณะ</option>
    <option value="เขตบางพลัด">เขตบางพลัด</option>
    <option value="เขตสะพานสูง">เขตสะพานสูง</option>
    <option value="เขตวังทองหลาง">เขตวังทองหลาง</option>
    <option value="เขตคลองสามวา">เขตคลองสามวา</option>
    <option value="เขตบางนา">เขตบางนา</option>
    <option value="เขตทวีวัฒนา">เขตทวีวัฒนา</option>
    <option value="เขตทุ่งครุ">เขตทุ่งครุ</option>
    <option value="เขตบางบอน">เขตบางบอน</option>

</select>

<br>

<label for="subdistrict">เลือกแขวง:</label>
<select id="subdistrict" name="subdistrict">

</select>

             <button type="submit"class="btnth">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>
</body>
    <script>
    function updateSubdistricts() {
        var districtSelect = document.getElementById("district");
        var subdistrictSelect = document.getElementById("subdistrict");


        subdistrictSelect.innerHTML = "";


        var selectedDistrict = districtSelect.value;


        var subdistrictOptions = getSubdistrictOptions(selectedDistrict);


        subdistrictOptions.forEach(function (option) {
            var optionElement = document.createElement("option");
            optionElement.value = option;
            optionElement.text = option;
            subdistrictSelect.add(optionElement);
        });
    }

    function getSubdistrictOptions(district) {


        switch (district) {
            case "เขตพระนคร":
                return ["แขวงชนะสงคราม", "แขวงตลาดยอด", "แขวงบวรนิเวศ", "แขวงบางขุนพรหม",
                    "แขวงบ้านพานถม", "แขวงพระบรมมหาราชวัง", "แขวงวังบูรพาภิรมย์", "แขวงวัดราชบพิธ",
                    "แขวงวัดสามพระยา", "แขวงศาลเจ้าพ่อเสือ", "แขวงสำราญราษฎร์", "แขวงเสาชิงช้า"];
            case "เขตดุสิต":
                return ["แขวงดุสิต", "แขวงถนนนครไชยศรี", "แขวงวชิรพยาบาล", "แขวงสวนจิตรลดา",
                    "แขวงสี่แยกมหานาค"];
            case "เขตหนองจอก":
                return ["แขวงกระทุ่มราย", "แขวงคลองสิบ", "แขวงคลองสิบสอง", "แขวงคู้ฝั่งเหนือ",
                    "แขวงโคกแฝด", "แขวงลำต้อยติ่ง", "แขวงลำผักชี", "แขวงหนองจอก"];
            case "เขตบางรัก":
                return ["แขวงบางรัก", "แขวงมหาพฤฒาราม", "แขวงสี่พระยา", "แขวงสีลม",
                    "แขวงสุริยวงศ์"];
            case "เขตบางเขน":
                return ["แขวงท่าแร้ง", "แขวงอนุสาวรีย์"];
            case "เขตบางกะปิ":
                return ["แขวงคลองจั่น", "แขวงหัวหมาก"];
            case "เขตปทุมวัน":
                return ["แขวงปทุมวัน", "แขวงรองเมือง", "แขวงลุมพินี", "แขวงวังใหม่",];
            case "เขตป้อมปราบศัตรูพ่าย":
                return ["แขวงคลองมหานาค", "แขวงบ้านบาตร", "แขวงป้อมปราบ", "แขวงวัดเทพศิรินทร์",
                "แขวงวัดโสมนัส"];
            case "เขตพระโขนง":
                return ["แขวงบางจาก"];
            case "เขตมีนบุรี":
                return ["แขวงมีนบุรี", "แขวงแสนแสบ"];
            case "เขตลาดกระบัง":
                return ["แขวงขุมทอง", "แขวงคลองสองต้นนุ่น", "แขวงคลองสามประเวศ", "แขวงทับยาว",
                "แขวงลาดกระบัง", "แขวงลำปลาทิว"];
            case "เขตยานนาวา":
                return ["แขวงช่องนนทรี", "แขวงบางโพงพาง"];
            case "เขตสัมพันธวงศ์":
                return ["แขวงจักรวรรดิ", "แขวงตลาดน้อย", "แขวงสัมพันธวงศ์"];
            case "เขตพญาไท":
                return ["แขวงสามเสนใน"];
            case "เขตธนบุรี":
                return ["แขวงดาวคะนอง", "แขวงตลาดพลู", "แขวงบางยี่เรือ", "แขวงบุคคโล",
                "แขวงวัดกัลยาณ์", "แขวงสำเหร่", "แขวงหิรัญรูจี"];
            case "เขตบางกอกใหญ่":
                return ["แขวงวัดท่าพระ", "แขวงวัดอรุณ"];
            case "เขตห้วยขวาง":
                return ["แขวงบางกะปิ", "แขวงสามเสนนอก", "แขวงห้วยขวาง"];
            case "เขตคลองสาน":
                return ["แขวงคลองต้นไทร", "แขวงคลองสาน", "แขวงบางลำภูล่าง", "แขวงสมเด็จเจ้าพระยา"];
            case "เขตตลิ่งชัน":
                return ["แขวงคลองชักพระ", "แขวงฉิมพลี", "แขวงตลิ่งชัน", "แขวงบางเชือกหนัง",
                "แขวงบางพรม", "แขวงบางระมาด"];
            case "เขตบางกอกน้อย":
                return ["แขวงบางขุนนนท์", "แขวงบางขุนศรี", "แขวงบ้านช่างหล่อ", "แขวงศิริราช",
                "แขวงอรุณอมรินทร์"];
            case "เขตบางขุนเทียน":
                return ["แขวงท่าข้าม", "แขวงแสมดำ"];
            case "เขตภาษีเจริญ":
                return ["แขวงคลองขวาง", "แขวงคูหาสวรรค์", "แขวงบางจาก", "แขวงบางด้วน",
                "แขวงบางแวก", "แขวงบางหว้า", "แขวงปากคลองภาษีเจริญ"];
            case "เขตสะพานสูง":
                return ["แขวงสะพานสูง"];
            case "เขตวังทองหลาง":
                return ["แขวงวังทองหลาง"];
            case "เขตคลองสามวา":
                return ["แขวงทรายกองดิน", "แขวงทรายกองดินใต้", "แขวงบางชัน", "แขวงสามวาตะวันตก",
                "แขวงสามวาตะวันออก"];
            case "เขตบางนา":
                return ["แขวงบางนา"];
            case "เขตทวีวัฒนา":
                return ["แขวงทวีวัฒนา", "แขวงศาลาธรรมสพน์"];
            case "เขตทุ่งครุ":
                return ["แขวงทุ่งครุ", "แขวงบางมด"];
            case "เขตบางบอน":
                return ["แขวงบางบอน"];

            default:
                return [];
        }
    }
    updateSubdistricts();
    </script>
            </form>
        </div>
        <?php
    } else {
        echo "ไม่พบข้อมูลผู้สอน";
    }
} else {
    echo "คุณไม่ได้เข้าสู่ระบบ";
}

$conn->close();
?>
</body>
</html>
