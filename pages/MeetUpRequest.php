<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #4A628A;
        }

        h1 {
            text-align: center;
            font-size: 50px;
        }

        h2 {
            font-size: 25px;
            text-align: center;
        }
        h5{
            font-size: 25px;
        }

        .big_container,
        .big_container_2 {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .container {
            width: 600px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: row;
            gap: 20px;
            padding: 20px;
            background-color: #B0C1D8;
        }

        .container img {
            width: 150px;
            height: 200px;
            border-radius: 10px;
        }

        .content {
            flex-grow: 1;
        }

        .content h1 {
            font-size: 20px;
            margin: 0 0 10px 0;
        }

        .content h3 {
            font-size: 16px;
            color: #555;
        }

        .dropdown_button {
            margin-top: 10px;
            background-color: #3675c2;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 110px;
            height: 30px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .dropdown_button:hover {
            background-color: #6b96c9;
            color: black;
        }

        .dropdown_content {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            background-color: #8E9EBE;
            box-shadow: 0px 4px 8px rgba(0.5, 0.5, 0.5, 0.5);
        }

        .button_absolute input {
            background-color: #455171;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button_absolute input:hover {
            background-color: #7b90b8;
            color: black;
        }
        </style>
    </head>
    <body>
        <h1>Want to book an appointment?</h1>   
        <h2>Come have an appointment with 
            our Doctors and Coaches!</h2><br>

        <!-- Sample -->
        <div class="big_container">
            <div class="container">
                <div class="container_child" >
                    <h5>Doctor Leni</h5>
                </div>

                <div class="container_child" >
                    <img src="Leni.jpg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            DR Leni chow <br>
                            Consultant Physician <br>
                            MBBS (Karachi), MCPS (PK), <br>
                            FCPS (PK) MRCP (Ireland)
                        </h3>
                        <div class="dropdown" id="dr1">
                            <button class="dropdown_button" onclick="toggleDropdown('dr1')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                        Dr. Leni Chow is a highly accomplished medical 
                                        professional with a distinguished career in healthcare. 
                                        She holds an MBBS degree from Karachi, showcasing her 
                                        foundational expertise in medicine, along with an MCPS 
                                        and FCPS from Pakistan, reflecting her specialized 
                                        training and excellence in clinical practice. Adding 
                                        to her global credentials, she has earned an MRCP from 
                                        Ireland, signifying her advanced proficiency in internal 
                                        medicine. With her extensive qualifications and dedication, 
                                        Dr. Chow is a trusted consultant physician known for her 
                                        compassionate care and commitment to improving patients' lives.
                                    </h4>
                                </div>
                            </div>
                        <a href="Leni.php" class="button_absolute">
                            <input type="button" value="Click here to book">
                        </a>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="container_child">
                    <h5>Doctor Mizhan</h5>
                </div>

                <div class="container_child">
                    <img src="Mizhan.jpg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            DR Mizhan <br>
                            Resident Physician <br>
                            MBBS (Monash Uni), <br>
                            Cert. NRP Cert. Men's Health
                        </h3>
                        <div class="dropdown" id="dr2">
                            <button class="dropdown_button" onclick="toggleDropdown('dr2')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                    Dr. Mizhan is a dedicated Resident Physician renowned for his 
                                    commitment to patient well-being and a focus on men's health. 
                                    He graduated with an MBBS degree from Monash University, showcasing 
                                    his strong academic foundation and clinical training. In addition to 
                                    his medical degree, he holds certifications in the Neonatal Resuscitation 
                                    Program (NRP) and Men's Health, equipping him to handle diverse healthcare 
                                    challenges. Dr. Mizhan is known for his compassionate care, modern approach 
                                    to medicine, and attention to preventative health. He strives to provide holistic,
                                     personalized solutions to improve the quality of life for his patients.
                                    </h4>
                                </div>
                            </div>
                        <a href="Mizhan.php" class="button_absolute">
                            <input type="button" value="Click here to book">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="big_container_2">
            <div class="container">
                <div class="container_child">
                    <h5>Coach Abriel</h5>
                </div>
                <div class="container_child">
                    <img src="Abriel.jpg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            Coach Abriel <br>
                            Advisor Consultant Cardiologist <br>
                            MD (UKM), MRCP (UK), <br>
                            MRCP (Ireland)
                        </h3>
                        <div class="dropdown" id="dr3">
                            <button class="dropdown_button" onclick="toggleDropdown('dr3')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                    Coach Abriel is an esteemed Advisor Consultant Cardiologist, 
                                    recognized for his expertise in cardiovascular care and preventative 
                                    health strategies. He earned his MD from Universiti Kebangsaan Malaysia 
                                    (UKM), laying a strong foundation for his medical career. Adding to his 
                                    credentials, he holds dual MRCP certifications from both the UK and Ireland, 
                                    reflecting his advanced training in cardiology. With a patient-centered approach, 
                                    Coach Abriel excels in providing comprehensive heart health solutions. Known for his 
                                    dedication and compassionate care, he is committed to empowering individuals to 
                                    lead healthier, heart-conscious lifestyles.
                                </div>
                            </div>
                        <a href="Abriel.php" class="button_absolute">
                            <input type="button" value="Click here to book">
                        </a>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="container_child">
                    <h5>Coach Hans</h5>
                </div>
                <div class="container_child">
                    <img src="Hans.jpg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            Coach Hans <br>
                            Resident Physician <br>
                            MBBS (Monash Uni), <br>
                            Cert. NRP Cert. Men's Health
                        </h3>
                        <div class="dropdown" id="dr4">
                            <button class="dropdown_button" onclick="toggleDropdown('dr4')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                        Coach Hans is a dedicated Resident Physician with a strong focus 
                                        on men's health and preventive care. He completed his MBBS at 
                                        Monash University, showcasing his robust medical training. Additionally, 
                                        he holds certifications in Neonatal Resuscitation Program (NRP) and Men’s 
                                        Health, emphasizing his expertise in providing tailored healthcare solutions. 
                                        Coach Hans is deeply committed to improving patient outcomes through personalized 
                                        care and education. His compassionate approach and specialized knowledge make him 
                                        a trusted advocate for promoting overall well-being and health awareness.
                                    </h4>
                                </div>
                            </div>
                        <a href="Hans.php" class="button_absolute">
                            <input type="button" value="Click here to book">
                        </a>
                    </div>
                </div>
            </div>
        </div>

<script>
    function toggleDropdown(id){
        const dropdown = document.getElementById(id);
        const dropdownContent = dropdown.getElementsByClassName("dropdown_content")[0];

        if (dropdownContent.style.display == "block"){
            dropdownContent.style.display = "none";
        }
        else{
            dropdownContent.style.display = "block";
        }
    }

    window.onclick = function(event){
        if(!event.target.matches('.dropdown_button') && !event.target.matches('.dropdown_content')){
            const dropdowns = document.querySelectorAll('.dropdown_content');
            dropdowns.forEach(function(dropdown){
                        dropdown.style.display = 'none';
            });
        }
    };
    </script>
</body>
</html>