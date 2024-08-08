<?php

if(isset($_GET['q'])){
    $query = $_GET['q'];
    try{
        $db = new PDO('sqlite:data.sqlite');
            
        $stmt = $db->query("SELECT toan, ngu_van, ngoai_ngu, vat_li, hoa_hoc, sinh_hoc, lich_su, dia_li, gdcd FROM diem_thi_thpt_2024 where sbd LIKE :query");
        $stmt->execute([':query' => "%$query%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }catch(PDOException $e){
        die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
    }

}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu điểm thi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@400..800&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Mitr:wght@200;300;400;500;600;700&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Oswald:wght@500;600&family=Poppins:ital,wght@1,200&family=Roboto:wght@500&display=swap');
        * {
            font-family: "Mitr", sans-serif;
            font-weight: 300;
            font-style: normal;
            color: white;
        }
        
        body {
            font-size: 16px;
            margin: 0px;
            padding: 0px;
            background-color: #31609a;
            background-size: cover;
        }
        
        .container {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-left: 10px;
            padding-right: 10px;
        }
        
        #title {
            text-transform: uppercase;
            font-size: 32px;
            font-weight: 500 !important;
            color: yellow;
            text-align: center;
            text-shadow: 0px 0px 3px black;
            margin-top: 40px;
            padding-left: 15px;
            padding-right: 15px;
        }
        
        #search-form {
            width: 400px;
            height: 40px;
            border: 1.4px solid white;
            overflow: auto;
            border-radius: 50px 50px 50px 50px;
            display: flex;
            align-items: center;
            margin: 10px;
        }
        
        .search-box {
            float: left;
            width: 330px;
            height: 30px;
            background: transparent;
            border: none;
            outline: none;
            color: white;
            padding-left: 20px;
        }
        
         ::placeholder {
            color: rgb(214, 214, 214);
        }
        
        .search-submit {
            float: right;
            height: 30px;
            font-size: 16px;
            border: none;
            background: transparent;
        }
        
        .search-submit:hover {
            font-size: 18px;
            cursor: pointer;
        }
        
        .vertical_divider {
            border-left: 1.4px solid white;
            height: 65%;
            margin-right: 7px;
        }
    </style>
</head>
<body>
    <h1 id="title">Tra cứu điểm thi tốt nghiệp THPT Quốc Gia 2024</h1>
    <div class="container">
        <form role="search" id="search-form" method="GET" action="index.php">
            <input type="text" class="search-box" name="q" placeholder="Nhập số báo danh..." autofocus>
            <span class="vertical_divider"></span>
            <button type="submit" class="search-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <div class="container">
                <?php 
                if(isset($_GET['q'])){
                    if ($result) {
                        echo "Số báo danh: ". $query . "<br>";
                        foreach($result as $value){
                            echo " Toán: ". $value["toan"];
                            echo " Văn: ".$value["ngu_van"];
                            echo " Ngoại ngữ: ".$value["ngoai_ngu"]. "<br>";
                            if(floatval($value["vat_li"])!=0 && floatval($value["hoa_hoc"])!=0 && floatval($value["sinh_hoc"])!=0){
                                if(floatval($value["vat_li"])!=0){
                                    echo " Vật lí: ".$value["vat_li"];
                                }
                                if(floatval($value["hoa_hoc"])!=0){
                                    echo " Hóa học: ".$value["hoa_hoc"];
                                }
                                if(floatval($value["sinh_hoc"])!=0){
                                    echo " Sinh học: ".$value["sinh_hoc"];
                                }
                                echo " KHTN = ". round((floatval($value["vat_li"]) + floatval($value["hoa_hoc"]) + floatval($value["sinh_hoc"]))/3,1);
                            }elseif(floatval($value["lich_su"])!=0 && floatval($value["dia_li"])!=0 && floatval($value["gdcd"])!=0){
                                if(floatval($value["lich_su"])!=0){
                                    echo " Lịch sử: ".$value["lich_su"];
                                }
                                if(floatval($value["dia_li"])!=0){
                                    echo " Địa lí: ".$value["dia_li"];
                                }
                                if(floatval($value["gdcd"])!=0){
                                    echo " Giáo dục công dân: ".$value["gdcd"];
                                }
                                echo " KHXH = ". round((floatval($value["lich_su"]) + floatval($value["dia_li"]) + floatval($value["gdcd"]))/3,1);
                            }
                        }
                    }else{
                        ?><p> Không tồn tại số báo danh trên!</p><?php
                    }
                }else{
                    ?><p>Dữ liệu có giới hạn! số báo danh chỉ từ (1000001 -> 1000100)</p><?php
                }?>
    </div>
</body>

</html>
