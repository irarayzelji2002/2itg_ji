<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Concepts in PHP</title>
</head>
<body>
    <h1>FOR REFERENCE</h1>
    <div style="width:800px"><p style="text-align:center;">UML Class Diagram</p>
    <img src="MP2_UML_Class_Diagram.png" alt="UML Class Diagram" width="800px" height="100%"></div>
    
    <?php
    class CICS_Subjects {
        private $subjName; //string ex: Applications Development and Emerging Technologies2 (Enterprise-Back-End)
        private $subjCode; //string ex: ICS
        private $subjNum; //int ex: 2609

        //CONSTRUCTOR
        function __construct($subjName, $subjCode, $subjNum) {
            self::setSubjName($subjName);
            self::setSubjCode($subjCode);
            self::setSubjNum($subjNum);
        }

        //SETTERS
        public function setSubjName($name) {
            $name = trim($name);
            $this->subjName=$name;
        }
        public function setSubjCode($code) {
            $code = trim($code);
            if(preg_match('~[0-9]+~', $code))
                echo "Subject code shouldn't contain numbers. <br>";
            else
                $this->subjCode = strtoupper($code);
        }
        public function setSubjNum($num) {
            $num = trim($num);
            if(is_numeric($num)) //if characters are numeric
                $this->subjNum = $num;
            else
                echo "Subject number must be a number. <br>";
        }

        //GETTERS
        public function getSubjName() {
            return $this->subjName;
        }
        public function getSubjCode() {
            return $this->subjCode;
        }
        public function getSubjNum() {
            return $this->subjNum;
        }

        //DISPLAY INFO
        public function displayInfo() {
            echo self::getSubjCode() . self::getSubjNum() .": ". self::getSubjName()."<br>";
        }
    }

    class IT_ELEC_Subjects extends CICS_Subjects {
        private $ITTrack;
        public static $selectedITTrack = array("Network and Security", "IT Automation", "Web and Mobile App Development");

        //CONSTRUCTOR
        function __construct($subjName, $subjCode, $subjNum, $ITTrack) {
            self::setITTrack($ITTrack);
            parent::__construct($subjName, $subjCode, $subjNum);
        }

        //SETTERS
        public function setITTrack($num) {
            $num = trim($num);
            if($num==0 || $num==1 || $num==2)
                $this->ITTrack=$num;
            else
                echo "IT track must be a 0, 1 , or 2. <br>";
        }

        //GETTERS (customized getter)
        public function getITTrack() {
            $track = "";
            if ($this->ITTrack == 0)
                $track = self::$selectedITTrack[0];
            elseif ($this->ITTrack == 1)
                $track = self::$selectedITTrack[1];
            else //ITTrack==2
                $track = self::$selectedITTrack[2];
            return $track;
        }

        //PRINT INFO (overloading)
        public function __call($fn, $arg) {
            if($fn=="printInfo") {
                $c=count($arg);
                switch($c) {
                    case 0: echo self::getITTrack()."<br>"; break;
                    case 1:
                        if ($arg[0]=="subjName")
                            echo $this->getSubjName()."<br>";
                        elseif ($arg[0]=="subjCode")
                            echo $this->getSubjCode()."<br>";
                        elseif ($arg[0]=="subjNum")
                            echo $this->getSubjNum()."<br>";
                        elseif ($arg[0]=="ITTrack")
                            echo $this->getITTrack()."<br>";
                        else
                            echo "Can't print info. <br>"; break;
                        break;
                    default:
                        echo "Can't print info."; break;
                }
            }
        }

        //DISPLAY INFO (overriden)
        public function displayInfo() {
            $letter="";
            
            if (self::getITTrack()==self::$selectedITTrack[0])
                $letter="A";
            elseif (self::getITTrack()==self::$selectedITTrack[1])
                $letter="B";
            else //ITTrack==2
                $letter="C";

            echo self::getSubjCode() . self::getSubjNum() . $letter;
            echo ": ". self::getSubjName() ." (". self::getITTrack() .")"."<br>";
        }
    }
    
    class IS_ELEC_Subjects extends CICS_Subjects {
        private $ISTrack;
        public static $selectedISTrack = array("Business Analytics", "Service Management");

        //CONSTRUCTOR
        function __construct($subjName, $subjCode, $subjNum, $ISTrack) {
            self::setISTrack($ISTrack);
            parent::__construct($subjName, $subjCode, $subjNum);
        }

        //SETTERS
        public function setISTrack($num) {
            $num = trim($num);
            if($num==0 || $num==1)
                $this->ISTrack=$num;
            else
                echo "IS track must be a 0 or 1. <br>";
        }

        //GETTERS (customized getter)
        public function getISTrack() {
            $track = "";
            if ($this->ISTrack == 0)
                $track = self::$selectedISTrack[0];
            else //ISTrack==1
                $track = self::$selectedISTrack[1];
            return $track;
        }

        //PRINT INFO
        public function printInfo() {
            echo self::getISTrack()."<br>";
        }
        
        //DISPLAY INFO (overriden)
        public function displayInfo() {
            $letter="";
            
            if (self::getISTrack()==self::$selectedISTrack[0])
                $letter="BA";
            else //ISTrack==2
                $letter="SM";

            echo self::getSubjCode() . self::getSubjNum() . $letter;
            echo ": ". self::getSubjName() ." (". self::getISTrack() .")"."<br>";
        }
    }

    class CS_ELEC_Subjects extends CICS_Subjects {
        private $CSTrack;
        public static $selectedCSTrack = array("Core Computer Science", "Game Development", "Data Science");

        //CONSTRUCTOR
        function __construct($subjName, $subjCode, $subjNum, $CSTrack) {
            self::setCSTrack($CSTrack);
            parent::__construct($subjName, $subjCode, $subjNum);
        }

        //SETTERS
        public function setCSTrack($num) {
            $num = trim($num);
            if($num==0 || $num==1 || $num==2)
                $this->CSTrack=$num;
            else
                echo "CS track must be a 0, 1 , or 2. <br>";
        }

        //GETTERS (customized getter)
        public function getCSTrack() {
            $track = "";
            if ($this->CSTrack == 0)
                $track = self::$selectedCSTrack[0];
            elseif ($this->CSTrack == 1)
                $track = self::$selectedCSTrack[1];
            else //CSTrack==2
                $track = self::$selectedCSTrack[2];
            return $track;
        }

        //PRINT INFO
        public function printInfo() {
            echo self::getCSTrack()."<br>";
        }
        
        //DISPLAY INFO (overriden)
        public function displayInfo() {
            $letter="";
            
            if (self::getCSTrack()==self::$selectedCSTrack[0])
                $letter="A";
            elseif (self::getCSTrack()==self::$selectedCSTrack[1])
                $letter="B";
            else //CSTrack==2
                $letter="C";

            echo self::getSubjCode() . self::getSubjNum() . $letter;
            echo ": ". self::getSubjName() ." (". self::getCSTrack() .")"."<br>";
        }
    }

    class multi_Inheritance extends IT_ELEC_Subjects{
        private $message;

        //CONSTRUCTOR (1 argument)
        function __construct($message) {
            self::setMessage($message);
        }

        //SETTERS
        public function setMessage($text) {
            $text = trim($text);
            $this->message=$text;
        }

        //GETTERS
        public function getMessage() {
            return $this->message;
        }

        //PRINT INFO
        public function printInfo() {
            echo self::getMessage()."<br>";
        }

        //DISPLAY INFO (overriden)
        public function displayInfo() {
            $letter="";
            
            if (self::getITTrack()==self::$selectedITTrack[0])
                $letter="A";
            elseif (self::getITTrack()==self::$selectedITTrack[1])
                $letter="B";
            else //ITTrack==2
                $letter="C";

            echo self::getSubjCode() . self::getSubjNum() . $letter;
            echo ": ". self::getSubjName() ." (". self::getITTrack() .") - ". self::getMessage()."<br>";
        }
    }
    
    //TESTING
    echo "<h1>TESTING</h1>";
    //CORRECT INPUTS
    echo "<h2>CORRECT INPUTS</h2>";
    $cicsSub1 = new CICS_Subjects("Applications Development and Emerging Technologies2 (Enterprise-Back-End)", "ICS", 2609);
    echo $cicsSub1->getSubjCode()."<br>";
    $cicsSub1->displayInfo();
    echo "<hr>";

    $itElecSub1 = new IT_ELEC_Subjects("Intermediate Web Application Development", "IT-ELEC", 1, 2);
    echo $itElecSub1->getSubjName()."<br>";
    $itElecSub1->printInfo();
    $itElecSub1->displayInfo();
    $itElecSub1->setSubjName("CCNA Security"); //changed attributes
    $itElecSub1->setSubjCode("IT ELEC");
    $itElecSub1->setSubjNum("2");
    $itElecSub1->setITTrack("0");
    $itElecSub1->displayInfo();
    $itElecSub1->printInfo("subjName");
    $itElecSub1->printInfo("subjCode");
    $itElecSub1->printInfo("subjNum");
    $itElecSub1->printInfo("ITTrack");
    
    echo "<hr>";
    
    $isElecSub1 = new IS_ELEC_Subjects("Fundamentals of Analytics Modeling", "ELE", 3, 0);
    $isElecSub1->printInfo();
    $isElecSub1->displayInfo();
    echo "<hr>";
    
    $csElecSub1 = new CS_ELEC_Subjects("Game Design and Concepts", "CS-ELEC", 1, 1);
    $csElecSub1->printInfo();
    $csElecSub1->displayInfo();
    echo "<hr>";

    //INCORRECT INPUTS
    echo "<h2>INCORRECT INPUTS</h2>";
    $cicsSub2 = new CICS_Subjects("Applications Development and Emerging Technologies2 (Enterprise-Back-End)", "ICS1", "2609");
    $cicsSub2->displayInfo();
    echo "<hr>";

    $itElecSub2 = new IT_ELEC_Subjects("Intermediate Web Application Development", "IT-ELEC1", "1a", "2a");
    $itElecSub2->printInfo();
    $itElecSub2->displayInfo();
    $itElecSub1->printInfo("others");
    $itElecSub1->printInfo("subjCode", "subjNum"); //can only take 1 argument
    echo "<hr>";

    $isElecSub2 = new IS_ELEC_Subjects("Fundamentals of Analytics Modeling", "1", "3", "0");
    $isElecSub2->printInfo();
    $isElecSub2->displayInfo();
    echo "<hr>";

    $csElecSub2 = new CS_ELEC_Subjects("Game Design and Concepts", "CS-ELEC3", 1, "1a");
    $csElecSub2->printInfo();
    $csElecSub2->displayInfo();
    echo "<hr>";

    //MULTI INHERITANCE
    echo "<h2>MULTI INHERITANCE</h2>";
    $message = new multi_Inheritance("This is child of \"IT_ELEC_Subjects\" class that is a child of \"Subjects\" class.");
    echo $message->getMessage()."<br>";
    $message->printInfo();
    $message->getSubjCode();
    $message->setSubjCode("IT-ELEC");
    $message->setSubjNum("4");
    $message->setSubjName("Intelligence Systems");
    $message->setITTrack("1");
    $message->displayInfo();

    ?>
</body>
</html>