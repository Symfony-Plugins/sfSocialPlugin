<?php
$arr = array();
foreach ($contacts as $contact)
{
  $arr[] = implode('|', array('id'   => $contact->getUserTo(),
                              'name' => $contact->getSfGuardUserRelatedByUserTo()->getUsername(),
                              'img'  => $contact->getSfGuardUserRelatedByUserTo()->getProfile()->getPicture(),
                              )
                   );
}
echo implode(PHP_EOL, $arr);