<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครเทรนเนอร์</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
            
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }


        .wrapper {
            max-width: 550px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-weight: 600;
        }

        form {
            width: 100%;
        }

        .input-box {
            margin-top: 30px;
            margin-bottom: 30px;
            position: relative;
        }

        .input-box input {
            padding: 10px;
            width: 100%;

            border-radius: 8px;
            outline: none;
            border: 1px solid #333;
            transition: border-color 0.3s ease;
        }

        .input-box input:focus {
            border-color: #007bff;
        }

        .placeholders {
            position: absolute;
            top: 50%;
            left: 8px;
            font-size: 14px;
            padding: 0px 5px;
            color: #666;
            transform: translateY(-50%);
            transition: top 0.3s ease, color 0.3s ease, background-color 0.3s ease;
            pointer-events: none;
        }

        .input-box input:focus + .placeholders,
        .input-box input:not(:placeholder-shown) + .placeholders {
            top: -10px;
            color: #007bff;
            font-weight: bold;
            background-color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px ;
            text-align: center;
        }


        /* กำหนดความกว้างของคอลัมน์แรก */
        th:nth-child(1),
        td:nth-child(1) {
            width: 60%; /* กำหนดความกว้างของคอลัมน์แรกเป็น 30% หรือค่าที่คุณต้องการ */
        }

        /* กำหนดความกว้างของคอลัมน์ที่สอง */
        th:nth-child(2),
        td:nth-child(2) {
            width: 20%; /* กำหนดความกว้างของคอลัมน์ที่สองเป็น 20% หรือค่าที่คุณต้องการ */
        }

        /* กำหนดความกว้างของคอลัมน์ที่สาม */
        th:nth-child(3),
        td:nth-child(3) {
            width: 20%; /* กำหนดความกว้างของคอลัมน์ที่สามเป็น 50% หรือค่าที่คุณต้องการ */
        }

        .input-radio {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .radio-options {
            display: flex;
        }

        .input-radio div {
            font-weight:400;
            margin-right: 10px;
        }

        .input-radio input[type="radio"] {
            margin-right: 10px;
            margin-left: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        select {
            padding: 10px;
            border-radius: 8px;
            outline: none;
            border: 1px solid #333;
            transition: border-color 0.3s ease;
            width: 100%;
            max-width: 300px;
        }

        select:focus {
            border-color: #007bff;
        }

        .input-box select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            outline: none;
            border: 1px solid #333;
            transition: border-color 0.3s ease;
            max-width: 100%;
        }

        .wrapper .btn {
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            margin: 10px;
            height: 55px;
            text-align: center;
            border: none;
            background-size: 300% 100%;
            border-radius: 50px;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
            background-image: linear-gradient(
                    to right,
                    #25aae1,
                    #4481eb,
                    #04befe,
                    #3f86ed
            );
            box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75);
        }

        .wrapper .btn:hover {
            background-position: 100% 0;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .wrapper .btn:focus {
            outline: none;
        }
    </style>
</head> 
<body>
    <div class="wrapper">
        <h1>สมัครเทรนเนอร์</h1>
        <form action="submit_trainer.php" method="POST" enctype="multipart/form-data">
            <p>สมัครสมาชิก</p>
            <div class="input-box">
                <input type="text" name="trainerusername" placeholder=" " required>
                <label class="placeholders">ชื่อผู้ใช้<span style="color: red;">*</span></label>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder=" " required>
                <label class="placeholders">รหัสผ่าน<span style="color: red;">*</span></label>
            </div>

            <p>ประวัติส่วนตัว</p>

            <div class="input-box">
                <input type="text" name="first_name" placeholder=" " required>
                <label class="placeholders">ชื่อ<span style="color: red;">*</span></label>
            </div>

            <div class="input-box">
                <input type="text" name="last_name" placeholder=" " required>
                <label class="placeholders">นามสกุล<span style="color: red;">*</span></label>
            </div>

            <div class="input-box">
                <input type="email" name="emailtrainer" placeholder=" " required>
                <label class="placeholders">อีเมล<span style="color: red;">*</span></label>
            </div>
            <div class="input-box">
                <input type="tel" name="phone_number" placeholder=" " maxlength="10" required>
                <label class="placeholders">เบอร์โทรศัพท์<span style="color: red;">*</span></label>
            </div>

            <div class="input-box">
                <input type="number" name="age" placeholder=" " required>
                <label class="placeholders">อายุ<span style="color: red;">*</span></label>
            </div>
            
            <div class="input-radio">
            <div>เพศ <span style="color: red;">*</span></div><br>
            <div class="radio-options">
                <label for="male">
                    <input type="radio" id="male" name="gender" value="ชาย" required>
                    ชาย
                </label><br>
                <label for="female">
                    <input type="radio" id="female" name="gender" value="หญิง" required>
                    หญิง
                </label><br>
                <label for="other">
                    <input type="radio" id="other" name="gender" value="อื่นๆ" required>
                    อื่นๆ
                </label>
            </div>
        </div>
        <div class="input-box">
            <label for="bank">ธนาคาร <span style="color: red;">*</span></label>
                <select id="bank" name="bank" required>
                    <option value="" disabled selected>กรุณาเลือกธนาคาร</option>
                    <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                    <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                    <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                    <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                    <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                    <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                    <option value="ธนาคารเกียรตินาคิน">ธนาคารเกียรตินาคิน</option>
                    <option value="ธนาคารซีไอเอ็มบีไทย">ธนาคารซีไอเอ็มบีไทย</option>
                    <option value="ธนาคารทิสโก้">ธนาคารทิสโก้</option>
                    <option value="ธนาคารธนชาต">ธนาคารธนชาต</option>
                    <option value="ธนาคารยูโอบี">ธนาคารยูโอบี</option>
                    <option value="ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)">ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)</option>
                    <option value="ธนาคารไทยเครดิตเพื่อรายย่อย">ธนาคารไทยเครดิตเพื่อรายย่อย</option>
                    <option value="ธนาคารแลนด์ แอนด์ เฮาส์">ธนาคารแลนด์ แอนด์ เฮาส์</option>
                    <option value="ธนาคารไอซีบีซี (ไทย)">ธนาคารไอซีบีซี (ไทย)</option>
                    <option value="ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย">ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย</option>
                    <option value="ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร">ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร</option>
                    <option value="ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย">ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย</option>
                    <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                    <option value="ธนาคารอาคารสงเคราะห์">ธนาคารอาคารสงเคราะห์</option>
                    <option value="ธนาคารอิสลามแห่งประเทศไทย">ธนาคารอิสลามแห่งประเทศไทย</option>
                    <option value="ธนาคารแห่งประเทศจีน">ธนาคารแห่งประเทศจีน</option>
                    <option value="ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)">ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)</option>
                    <option value="ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด">ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด</option>
                </select>
            </div>
            <div class="input-box">
                <input type="number" name="account_number" placeholder=" " required>
                <label class="placeholders">เลขที่บัญชี<span style="color: red;">*</span></label>
            </div>
            <div class="input-box">
            <p>สถานการศึกษา<span style="color: red;">*</span></p>
            <table>
                <tr>
                    <th>ระดับการศึกษา</th>
                    <th>ตั้งแต่<br>(พ.ศ.)</th>
                    <th>ถึง<br>(พ.ศ.)</th>
                </tr>
                <tr class="education-group">
                    <td><input type="text" name="level_2" class="education1" placeholder="ปวช."></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_2" class="education" placeholder="25xx" maxlength="4"></td>
                    <td><input oninput="checkYear(this)" type="number" name="end_year_2" class="education" placeholder="25xx" maxlength="4"></td>
                </tr>
                <tr class="education-group">
                    <td><input type="text" name="level_3" class="education1" placeholder="ปวส."></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_3" class="education" placeholder="25xx." maxlength="4"></td>
                    <td><input oninput="checkYear(this)" type="number" name="end_year_3" class="education" placeholder="25xx" maxlength="4"></td>
                </tr>
                <tr class="education-group">
                    <td><input type="text"  name="level_4" class="education1" placeholder="ปริญญาตรี"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_4" class="education" placeholder="25xx" maxlength="4"></td>
                    <td><input oninput="checkYear(this)" type="number" name="end_year_4" class="education" placeholder="25xx" maxlength="4"></td>
                </tr>
                <tr class="education-group">
                    <td><input type="text" name="level_5" class="education1" placeholder="สูงกว่าปริญญาตรี"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_5" class="education" placeholder="25xx" maxlength="4"></td>
                    <td><input oninput="checkYear(this)" type="number" name="end_year_5" class="education" placeholder="25xx" maxlength="4"></td>
                </tr>
                <tr class="education-group">
                    <td><input type="text" name="level_6" class="education1" placeholder="อื่น ๆ"></td>
                    <td><input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                        type="number" name="start_year_6" class="education" placeholder="25xx" maxlength="4"></td>
                    <td><input oninput="checkYear(this)" type="number" name="end_year_6" class="education" placeholder="25xx" maxlength="4"></td>
                </tr>
            </table>
        </div>
        <div class="form-group">
            <label for="image">รูปประจำตัว<span style="color: red;">*</span></label>
            <input type="file" class="form-control" id="image_proflie" name="image_profile">
        </div>

        <div class="input-box">
            <p>ที่อยู่ในกรุงเทพมหาคร</p>
            <label for="district">เลือกเขต:<span style="color: red;">*</span></label>
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
                <option value="เขตดินแดง">เขตดินแดง</option>
                <option value="เขตบึงกุ่ม">เขตบึงกุ่ม</option>
                <option value="เขตสาทร">เขตสาทร</option>
                <option value="เขตบางซื่อ">เขตบางซื่อ</option>
                <option value="เขตจตุจักร">เขตจตุจักร</option>
                <option value="เขตบางคอแหลม">เขตบางคอแหลม</option>
                <option value="เขตประเวศ">เขตประเวศ</option>
                <option value="เขตคลองเตย">เขตคลองเตย</option>
                <option value="เขตสวนหลวง">เขตสวนหลวง</option>
                <option value="เขตจอมทอง">เขตจอมทอง</option>
                <option value="เขตดอนเมือง">เขตดอนเมือง</option>
                <option value="เขตราชเทวี">เขตราชเทวี</option>
                <option value="เขตลาดพร้าว">เขตลาดพร้าว</option>
                <option value="เขตวัฒนา">เขตวัฒนา</option>
                <option value="เขตบางแค">เขตบางแค</option>
                <option value="เขตหลักสี่">เขตหลักสี่</option>
                <option value="เขตสายไหม">เขตสายไหม</option>
                <option value="เขตคันนายาว">เขตคันนายาว</option>
                <option value="เขตสะพานสูง">เขตสะพานสูง</option>
                <option value="เขตวังทองหลาง">เขตวังทองหลาง</option>
                <option value="เขตคลองสามวา">เขตคลองสามวา</option>
                <option value="เขตบางนา">เขตบางนา</option>
                <option value="เขตทวีวัฒนา">เขตทวีวัฒนา</option>
                <option value="เขตทุ่งครุ">เขตทุ่งครุ</option>
                <option value="เขตบางบอน">เขตบางบอน</option>
            </select>

            <label for="subdistrict">เลือกแขวง:<span style="color: red;">*</span></label>
            <select id="subdistrict" name="subdistrict"></select>
        </div>

        <div class="form-group">
            <label>กรุณาส่งใบรับรองการเป็นเทรนเนอร์ หรือ Certified Personal Trainer<span style="color: red;">*</span></label>
            <input type="file" class="form-control" name="image">
        </div>

        <button type="submit" class="btn">สมัครเทรนเนอร์</button>
    </form>
</div>

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

    const startYearInputs = document.querySelectorAll('input[name^="start_year_"]');
const endYearInputs = document.querySelectorAll('input[name^="end_year_"]');

endYearInputs.forEach((input, index) => {
    input.addEventListener('input', () => {
        if (input.value.trim() !== '' && input.value.trim().length === 4 && startYearInputs[index].value.trim() !== '' && parseInt(input.value) < parseInt(startYearInputs[index].value)) {
            alert('ปีสิ้นสุดต้องมากกว่าปีเริ่มต้น');
            input.value = '';
        }
    });
});


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
            case "เขตหนองแขม":
                return ["แขวงหนองแขม", "แขวงหนองค้างพลู"];
            case "เขตราษฎร์บูรณะ":
                return ["แขวงบางปะกอก", "แขวงราษฎร์บูรณะ"];
            case "เขตบางพลัด":
                return ["แขวงบางบำหรุ", "แขวงบางพลัด", "แขวงบางยี่ขัน", "แขวงบางอ้อ"];
            case "เขตดินแดง":
                return ["แขวงดินแดง"];
            case "เขตบึงกุ่ม":
                return ["แขวงคลองกุ่ม"];
            case "เขตสาทร":
                return ["แขวงทุ่งมหาเมฆ", "แขวงทุ่งวัดดอน", "แขวงยานนาวา"];
            case "เขตบางซื่อ":
                return ["แขวงบางซื่อ"];
            case "เขตจตุจักร":
                return ["แขวงจตุจักร", "แขวงจอมพล", "แขวงจันทรเกษม", "แขวงลาดยาว",
                "แขวงเสนานิคม"];
            case "เขตบางคอแหลม":
                return ["แขวงบางโคล่", "แขวงบางคอแหลม", "แขวงวัดพระยาไกร"];
            case "เขตประเวศ":
                return ["แขวงดอกไม้", "แขวงประเวศ", "แขวงหนองบอน"];
            case "เขตคลองเตย":
                return ["แขวงคลองเตย", "แขวงคลองตัน", "แขวงพระโขนง"];
            case "เขตสวนหลวง":
                return ["แขวงสวนหลวง"];
            case "เขตจอมทอง":
                return ["แขวงจอมทอง", "แขวงบางขุนเทียน", "แขวงบางค้อ", "แขวงบางมด"];
            case "เขตดอนเมือง":
                return ["แขวงสีกัน"];
            case "เขตราชเทวี":
                return ["แขวงถนนเพชรบุรี", "แขวงถนนพญาไท", "แขวงทุ่งพญาไท", "แขวงมักกะสัน"];
            case "เขตลาดพร้าว":
                return ["แขวงจรเข้บัว", "แขวงลาดพร้าว"];
            case "เขตวัฒนา":
                return ["แขวงคลองเตยเหนือ", "แขวงคลองตันเหนือ", "แขวงพระโขนงเหนือ"];
            case "เขตบางแค":
                return ["แขวงบางแค", "ขวงบางแคเหนือ", "แขวงบางไผ่", "แขวงหลักสอง"];
            case "เขตหลักสี่":
                return ["แขวงตลาดบางเขน", "แขวงทุ่งสองห้อง"];
            case "เขตสายไหม":
                return ["แขวงคลองถนน", "แขวงสายไหม", "แขวงออเงิน"];
            case "เขตคันนายาว":
                return ["แขวงคันนายาว"];
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
</body>
</html>