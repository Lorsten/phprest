<?php

// Class used for validating the data from the client
class validateData
{
    public $courseID;
    public $coursename;
    public $progression;
    public $courseSyllabus;

    // Method for setting the property $courseID
    function set_courseID($courseID)
    {
        if (!empty($courseID)) {
            $this->courseID = $this->sanitize($this->courseID = $courseID, 'string');
        }
    }

    function set_coursename($coursename)
    {
        if (!empty($coursename)) {
            $this->coursename = $this->sanitize($this->coursename = $coursename, 'string');
        };
    }
    function set_progression($progression)
    {
        if (!empty($progression)) {
            if (strlen($progression) === 1) {
                $this->progression = $this->sanitize($this->progression = $progression, 'string');
            }
        }
    }
    function set_syllabus($courseSyllabus)
    {
        if (!empty($courseSyllabus)) {

            $this->courseSyllabus = $this->sanitize($this->courseSyllabus = $courseSyllabus, 'url');
        }
    }
    // Method for retriving the  property $courseID
    function get_courseID()
    {
        return  $this->courseID;
    }
    function get_coursename()
    {
        return $this->coursename;
    }
    function get_progression()
    {
        return $this->progression;
    }
    function get_courseSyllabus()
    {
        return $this->courseSyllabus;
    }

    // Method for using filters 
    public function sanitize($item, $type)
    {
        if ($type === 'url') {
            $this->item = filter_var($item, FILTER_SANITIZE_URL);
        } else if ($type === 'string') {
            $this->item = filter_var($item, FILTER_SANITIZE_STRING);
        }
        return $this->item;
    }
    // Method for checking if the values contains any null by inserting them into an array and then using in_array()
    public function checkforNull()
    {
        $arr = [];
        array_push($arr, $this->get_courseID(), $this->get_coursename(), $this->get_progression(), $this->get_courseSyllabus());
        if (!in_array(null, $arr)) {
            return true;
        }
    }
}
