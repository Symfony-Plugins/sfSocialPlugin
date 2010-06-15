<?php
$arr = array();
foreach ($contacts as $contact)
{
  $arr[] = array('id'   => $contact->getUserTo(),
                 'name' => $contact->getTo()->getUsername(),
                 'img'  => $contact->getTo()->getProfile()->getPicture());
}
echo json_encode($arr);