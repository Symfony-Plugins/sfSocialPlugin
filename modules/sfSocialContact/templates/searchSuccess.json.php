<?php
$arr = array();
foreach ($contacts as $contact)
{
  $arr[] = array('id'   => $contact->getUserTo(),
                 'name' => $contact->getSfGuardUserRelatedByUserTo()->getUsername(),
                 'img'  => $contact->getSfGuardUserRelatedByUserTo()->getProfile()->getPicture());
}
echo json_encode(array('users' => $arr));
?>