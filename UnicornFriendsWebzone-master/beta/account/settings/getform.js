getForm("username");
function getForm(setting)
{
    document.getElementById("form").action = "/account/settings/impl-" + setting + ".php";
    
    if(setting == "delete" || setting == "reset")
        document.getElementById("formdata").innerHTML = "";
    else
        getXhttp("/account/settings/form-" + setting + ".php", "", "formdata");
}