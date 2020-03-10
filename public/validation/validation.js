
//===========================================================TXT FIELDS CHARACTER VALIDATION
function isNumeric(keyCode)

{
return ((keyCode >= 48 && keyCode <= 57) || keyCode == 8 || keyCode == 189 || keyCode == 37 || keyCode == 110 || keyCode == 190 || keyCode == 39 || (keyCode >= 96 && keyCode <= 105 || keyCode == 9))

}
function isAlpha(keyCode)

{

return ((keyCode >= 65 && keyCode <= 90) || keyCode == 8 || keyCode == 32 || keyCode == 190 || keyCode == 9 || keyCode == 188 || keyCode == 191 || keyCode == 37 || keyCode == 39)

}


function isAlphaNumeric(keyCode)

{
return ((keyCode >= 65 && keyCode <= 90) ||  (keyCode >= 48 && keyCode <= 57) || keyCode == 188 || keyCode == 8 || keyCode == 32 || keyCode == 190 || keyCode == 9 || keyCode == 109 || keyCode == 37 || keyCode == 39 || keyCode == 191 || (keyCode >= 96 && keyCode <= 105))
}

function isAlphaNumericId(keyCode)

{
return ((keyCode >= 65 && keyCode <= 90) ||  (keyCode >= 48 && keyCode <= 57) || keyCode == 188 || keyCode == 8 || keyCode == 190 || keyCode == 9 || keyCode == 191 || keyCode == 109 || keyCode == 37 || keyCode == 39 || (keyCode >= 96 && keyCode <= 105))
}


function isCurrency(keyCode)

{
return ((keyCode >= 48 && keyCode <= 57) || keyCode == 8 || keyCode == 189 || keyCode == 37 || keyCode == 39 || (keyCode >= 96 && keyCode <= 105 || keyCode == 9 || keyCode == 190 || keyCode == 110))
}


