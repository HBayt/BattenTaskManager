<h1> Tableau 3 D en PHP </h1>
<a 
    href="https://stackoverflow.com/questions/4108057/how-to-use-3-dimensional-array-in-php ">
    https://stackoverflow.com How to use 3 dimensional array in PHP
</a>


<?php 
    $rgbArray = 
    array(
        'red'=>array('weight'=>$weight, 'height'=>$height),
        'green'=>array('weight'=>$weight, 'height'=>$height),
        'blue'=>array('weight'=>$weight, 'height'=>$height)
    );

    $weight = $rgbArray['red']['weight']; 
    $height = $rgbArray['red']['height']; 


?> 


<div clase="container" > 
    If yours array <br> 

$rgbArray = <br> 
    array( <br> 
        'red'=>array('weight'=>$weight, 'height'=>$height), <br> 
        'green'=>array('weight'=>$weight, 'height'=>$height), <br> 
        'blue'=>array('weight'=>$weight, 'height'=>$height) <br> 
    );

    <br> 
    Then you can assign the value to rgbArray like <br> 
    $weight = $rgbArray['red']['weight']<br> 
    $height = $rgbArray['red']['height']<br> 

</div> 

<?php 

    $rgbArray = array('red'=>array($weight, $height),
                    'green'=>array($weight, $height),
                    'blue'=>array($weight, $height));

    $weight = $rgbArray['red'][0]
    $height = $rgbArray['red'][1]

?> 

<div clase="container" > 
    If yours array <br> 

    $rgbArray = 
        array(
            'red'=>array($weight, $height), <br> 
            'green'=>array($weight, $height), <br> 
            'blue'=>array($weight, $height)  <br> 
        ); <br> 

    <br> <br> 
    Then you can assign the value to rgbArray like <br> 
    $weight = $rgbArray['red'][0]<br> 
    $height = $rgbArray['red'][1]<br> 

</div> 

<br>
<hr> 
<br> 

<div clase="container" > 
    If yours array <br> 

    $t = 
        array(
            'group_libelle' 
                => array(  <br> 
                    'users' 
                        => array(
                            $user1, $user2, $user3, $user4
                        ) <br> 
                )
            ); <br> 

    <br> <br> 
    In simple words, if you want that, you can get: <br> 
    <br> 
    Loop 1 <br> 
    foreach ($t["group_libelle"]["users"] as $user)<br> 
        echo $user->name; <br> 
    <br> 

    <br> <br> 
    Loop 2 <br> 
    foreach ($t["group_libelle"] as $label) {<br> 
        echo $label; 
        <br> 
        foreach ($users as $user) {<br> 
            echo $user->name; <br> 
        }<br> 
    } <br> 
    <br> 
    In both case, you will get user1->name, user2->name, user3->name,user4->name in each iteration.<br> 
</div> 






