getselectele(1) ;
function getselectele(num)
{
    let attr ;
    if(num == 1)
        attr = "Breed" ;
    else if(num == 2)
        attr = "City" ;

    $.ajax({
        url: '../php/getselectele.php',
        type: 'POST',
        data: {
            ATTR: attr,
        },
        success: function (data) {

            let elearray = data.split("&");
            elearray[0] = elearray[0].slice(2);
            let selectbox = document.getElementById("button"+num.toString()) ;

            let anoption = document.createElement("option") ;


            let opvalue = geturlvalue("value") ;



            let tmp ;
            let flag = 0 ;

            let testpattern = /\+/ ;

            if(opvalue != undefined && testpattern.test(opvalue))
            {
                tmp = opvalue.split("+") ;
                flag = 1 ;
            }

            if(num == 1)
            {
                anoption.value = "Breed" ;
                anoption.innerText = "品种" ;
                anoption.className = "option" ;

            }
            else if(num == 2)
            {
                anoption.value = "City" ;
                anoption.innerText = "城市" ;
                anoption.className = "option" ;


            }

            selectbox.appendChild(anoption) ;

            for(let i = 0 ; i < elearray.length ; i++)
            {
                anoption = document.createElement("option") ;
                anoption.value = elearray[i] ;
                anoption.innerText = elearray[i] ;
                anoption.className = "option" ;

                if(flag == 1)
                {

                    let tmpvalue = anoption.value.replace(/^\s+/g,"");
                    tmpvalue = tmpvalue.replace(/^\n+/g,"") ;

                    if(encodeURI(tmpvalue) == tmp[0])
                        anoption.selected = true ;
                    if (encodeURI(tmpvalue) == tmp[1])
                        anoption.selected = true ;
                }


                selectbox.appendChild(anoption) ;
            }

            if(num == 1)
            {
                getselectele(2) ;
            }
            else
            {
                getOrg() ;
            }



        },
        error: function (err) {
            alert("fail");
        }
    });
}

function getOrg() {
    let sltcity = document.getElementById("button2") ;
    let sltorg     = document.getElementById("button3") ;
    sltorg.innerHTML = "" ;
    // alert(sltcity.value) ;
    $.ajax({
        url: '../php/getselectele.php',
        type: 'POST',
        data: {
            ATTR: "Org",
            NOW: sltcity.value,
        },
        success: function (data) {
            let elearray = data.split("&");
            let tmp =elearray[0].replace(/\s+/g,"");
            let tmp2 = tmp.replace(/\n+/g,"") ;
            elearray[0] = tmp2 ;
            // let tmp =elearray[0].replace(/\s+/g,"");

            let anoption = document.createElement("option") ;

            let opvalue = geturlvalue("value") ;
            let tmpcity ;
            let flag = 0 ;

            let testpattern = /\+/ ;

            if(opvalue != undefined && testpattern.test(opvalue))
            {
                tmpcity = opvalue.split("+") ;
                flag = 1 ;
            }


            anoption.value = "Org" ;
            anoption.innerText = "机构" ;
            anoption.className = "option" ;

            sltorg.appendChild(anoption) ;

            if(tmp != "")
            {
                for(let i = 0 ; i < elearray.length ; i++)
                {
                    anoption = document.createElement("option") ;
                    anoption.value = elearray[i] ;
                    anoption.innerText = elearray[i] ;
                    anoption.className = "option" ;

                    if(flag == 1)
                    {

                        let tmpvalue = anoption.value.replace(/^\s+/g,"");
                        tmpvalue = tmpvalue.replace(/^\n+/g,"") ;
                        // alert(tmpcity[2]) ;

                        if(encodeURI(tmpvalue) == tmpcity[2])
                            anoption.selected = true ;

                    }



                    sltorg.appendChild(anoption) ;
                }

            }

            if(geturlvalue("attr") == "Filter")
            {
                filterpic(decodeURI(geturlvalue("value"))) ;
            }

            else if(geturlvalue("page"))
            {
                getpic(decodeURI(geturlvalue("value")),decodeURI(geturlvalue("attr"))) ;
            }
            else
            {
                getpic(null,"ALL") ;
            }



        },
        error: function (err) {
            alert("fail");
        }
    })
}

function loadpic(path)
{
    let imgsrc = "../images/petimg/" + path ;
    document.getElementById("scenery").src = imgsrc ;
    document.getElementById("nopic").style.display="none";;
}

function displayprev(path)
{
    $.ajax({
        url:'../php/uploadgetselect.php',
        data:{
            PATH:path,
        },
        type:'POST',
        success:function(data){
            let tmp = data.split("&") ;
            let des = tmp[0] ;
            let name = tmp[1] ;
            let city = tmp[2] ;
            let gender = tmp[3] ;
            let age = tmp[4] ;
            let breed = tmp[5];
            // alert(org);
            if(des)
                $("#searcharea").html(des) ;
            else
                $("#searcharea").html("No description.") ;

            $("#search").val(name) ;
            // $("#button2").val(city) ;
            $("#button1").val(breed) ;
            $("#genderbutton").val(gender) ;
            $("#agebutton").val(age);
        },
        error:function (err) {
            alert(err) ;
        }
    })
}

function changeupload()
{
    let btn = document.getElementById("pica") ;
    btn.innerHTML = "Modify<input type=\"file\" name=\"file\" id=\"file\" onchange=\"showPreview(this, 'scenery')\" required>" ;
}

if(geturlvalue("mode") && geturlvalue("pic"))
{
    loadpic(geturlvalue("pic")) ;
    changeupload() ;
    displayprev(geturlvalue("pic"));
    modifymode(geturlvalue("pic")) ;
}
else
{
    uploadmode() ;
}

function modifymode(picpath)
{
    let submitbtn = document.getElementById("submit") ;
    let filebox = document.getElementById("file") ;
    filebox.required = false ;
    let Main = {
        methods: {
            open() {
                this.$alert('The title is too long', 'Input Error', {
                    confirmButtonText: 'Confirm',
                })
            }
        }
    };
    let Ctor = Vue.extend(Main);
    new Ctor().$mount('#alert2');
    submitbtn.onclick = function () {
        let titlelen = $("#search").val().length ;
        if(titlelen > 255)
        {
            document.getElementById("alertbutton2").click() ;
        }
        else
        {
            modify(picpath) ;
            event.preventDefault();
            aftersubmit() ;
        }
    }
}

function uploadmode() {
    let form = document.getElementById("form1") ;
    let Main = {
        methods: {
            open() {
                this.$alert('Do you want to upload?', 'Page Confirmation', {
                    confirmButtonText: 'Confirm',
                }).then(() => {
                    aftersubmit() ;
                });
            }
        }
    };
    let Ctor = Vue.extend(Main);
    new Ctor().$mount('#alert');

    let Main2 = {
        methods: {
            open() {
                this.$alert('The title is too long', 'Input Error', {
                    confirmButtonText: 'Confirm',
                })
            }
        }
    };
    let Ctor2 = Vue.extend(Main2);
    new Ctor2().$mount('#alert2');


    form.onsubmit = function () {
        let titlelen = $("#search").val().length ;
        if(titlelen > 255)
        {
            document.getElementById("alertbutton2").click() ;
        }
        else
        {
            document.getElementById("alertbutton").click() ;
        }

    }
}



function modify(picpath)
{
    let petname = document.getElementById("search").value ;
    let des = document.getElementById("searcharea").value ;

    let contentsel=document.getElementById("button1");
    let contentindex=contentsel.selectedIndex;
    let breed= contentsel.options[contentindex].text;

    let countrysel=document.getElementById("button2");
    let countryindex=countrysel.selectedIndex;
    let city= countrysel.options[countryindex].text;

    let citysel=document.getElementById("button3");
    let cityindex=citysel.selectedIndex;
    let org= citysel.options[cityindex].text;

    let gendersel=document.getElementById("genderbutton");
    let genderindex=gendersel.selectedIndex;
    let gender= gendersel.options[genderindex].text;

    let agesel=document.getElementById("agebutton");
    let ageindex=agesel.selectedIndex;
    let age= agesel.options[ageindex].text;

    // alert(title+"&"+des+"&"+country+"&"+city+"&"+content) ;

    $.ajax({
        url:'../php/modify.php',
        type:'POST',
        data:{
            img:picpath,
            petname:petname,
            description:des,
            breed:breed,
            org:org,
            city:city,
            gendertext:gender,
            agetext:age
        },
        success:function(data) {

        },
        error:function(err) {
            alert(err) ;
        }
    })
}

function aftersubmit() {
    window.location.href = "my_photo.html" ;
}

function update(picpath){
    let contentbox = document.getElementById("button1") ;
    let nationbox = document.getElementById("button2") ;
    let titlebox = document.getElementById("search") ;
    let desbox = document.getElementById("searcharea") ;

    $.ajax({
        url:'../php/details.php',
        type:'POST',
        data:{
            PATH:picpath,
        },
        success:function(data) {
            let tmp = data.split("&") ;
            let nation = tmp[1] ;
            let city = tmp[2] ;
            let des = tmp[3] ;
            let content = tmp[4] ;
            let title = tmp[5] ;

            let contentlen = contentbox.options.length ;

            for(let i = 0 ; i < contentlen ; i++)
            {
                if(contentbox.options[i].value == content)
                {
                    contentbox.options[i].selected = true ;
                }
                else
                {
                    contentbox.options[i].selected = false ;
                }
            }

            let nationlen = nationbox.options.length ;

            for(let i = 0 ; i < nationlen ; i++)
            {
                if(nationbox.options[i].value == nation)
                {
                    nationbox.options[i].selected = true ;
                    getCity(city) ;
                }
                else
                {
                    nationbox.options[i].selected = false ;
                }
            }
            titlebox.value = title ;
            desbox.value = des ;


        },
        error:function(err) {

        }
    })
}


