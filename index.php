<?php
    $menu_items = [
        "እምዩምኒሊክ ክፍለ ከተማ" => ["Loret Afewerk", "Nigest Eleni", "Fit Awrary", "Ansas Mariam", "selam Chora", "Eyerus Alem"],
        "አፄ ዘርያቆብ ክፈለ ከተማ" => ["Andnet", "Debre Eba", "Ureal", "Midre Genet", "Hailemariam mamo"],
        "እቴጌ ጣይቱ ክፍለ ከተማ" => ["Ayer Tena", "Giyorgis", "Lche", "Shewareged"],
        "ጠባሴ ክፍለ ከተማ" => ["Gebreal", "Mesalemia", "Bahir Hail", "Addis Genet", "Sahile Selassie"],
        "ጫጫ ክፍለ ከተማ" => ["Selam Ber", "Kebede Michael", "Niguse HaileMelkot", "Misrak Tsehay"]
    ];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Deberberhan Water Meter Reading</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="logo">
        <img src="10.png">
    </div>
    <div class="menu_bar">
        <h1 style="color: white;">የደ/ብርሃን ከተማ ውሃና ፍሳሽ አገልግሎት ኦን ላይን ንባብ መመዝገቢያ ገፅ</h1>
        <ul>
            <?php foreach ($menu_items as $menu_title => $sub_items): ?>
                <li class="active"><a href="#"><i class="fa fa-address-book"></i><?php echo $menu_title; ?></a>
                    <div class="sub-menu-1">
                        <ul>
                            <?php foreach ($sub_items as $sub_item): ?>
                                <li><a href="reading_format.php?area=<?php echo urlencode($sub_item); ?>"><?php echo $sub_item; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach; ?>
            <li><a href="login.php"><i class="fa fa-address-book"></i>Admin Login</a></li>
        </ul>
    </div>
    <footer style="position: fixed; bottom: 0; width: 100%; background-color: #333; color: white; text-align: center; padding: 10px 0;">
        <div class="footer-content">
            <p>&copy; 2025 Deberberhan Town Water supply and sewarge office. All rights reserved.</p>
        </div>
        <div class="footer-links">
            <a href="#" style="color: white; margin: 0 10px;">Developed by </a>
            <a href="#" style="color: white; margin: 0 10px;">Yifru Gizachew</a>
        </div>
    </footer>
</body>

</html>
