<?php
    session_start();
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $nameOfReq = $_POST['nameofRequest'];
    $docs = $_POST['docs'];
    $pharmas = $_POST['pharmacist'];
    $staff = $_POST['staff'];
    $docsArray = explode(',',$docs); 
    $staffArray = explode(',',$staff);
    $query = 'SELECT * from DOCTORS' .$emailarr[0];
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $resDocs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $query = 'SELECT * from STAFF'.$emailarr[0];
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $resStaff = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <style>
        .fancy-text{
            font-size: 22px;
        }
        .back{
            top:90%;
            left: 20px;
            position: absolute;
        }
        .next{
            top: 90%;
            right: 20px;
            position: absolute;
        }

    </style>
        <div class="right-top text-white">
            <div class="notification">Select Doctor</div>
        </div>
        <div class="right-bottom">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return false">
                <input type="hidden" name="req" class="req" value="<?php echo $nameOfReq; ?>">
                <input type="hidden" name="docsName" class="docs" value="<?php echo $docs; ?>">
                <input type="hidden" name="docsName" class="staff" value="<?php echo $staff; ?>">
                <input type="hidden" name="docsName" class="pharmas" value="<?php echo $pharmas; ?>">
                <div class="doc-form-container2">       
                    <div class="form-group row mt-5">
                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm fancy-text">Select Doctor</label>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-7">
                            <select name="selected" id="docSelector">
                                <?php foreach($resDocs as $r):  ?>
                                    <option value="<?php echo $r['Name'] ?>"><?php echo $r['Name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="w-80Per" id="docList">
                                <?php foreach($docsArray as $doc): 
                                    if($doc!=''): ?>
                                    <span class="listItem">
                                        <span><?php echo $doc; ?></span>
                                        <button onclick="funcDoc(<?php echo '\'$doc ;\'' ?>)" class="listRef btn btn-primary">x</button>
                                    </span>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-5">
                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm fancy-text">Select Staff</label>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-7">
                            <select name="selected" id="staffSelector">
                                <?php $var = 1; foreach($resDocs as $r):  ?>
                                    <option value="<?php echo $r['Name'] ?>"><?php echo $r['Name'] ?></option>
                                <?php $var++; endforeach; ?>
                            </select>
                            <div class="w-80Per" id="staffList">
                                <?php foreach($staffArray as $staffVar): 
                                    if($doc!=''): ?>
                                    <span class="listItem">
                                        <span><?php echo $staffVar; ?></span>
                                        <button onclick="funcDoc(<?php echo '\'$staffVar;\'' ?>)" class="listRef btn btn-primary">x</button>
                                    </span>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <button class="back btn btn-primary" id="back" >Previous</button>
            <button class="next btn btn-primary" id="next">Next</button>
        </div>
    <script>
        var docList = [];
        var staffList = [];
        var doctorsVal = $('.docs').val();
        var staffVal = $('.staff').val();
        if(doctorsVal!=='')
            docList = doctorsVal.split(',');
        if(staffVal!=='')
            staffList = staffVal.split(',');
        $('#back').click(function(){
            window.location.reload();
        })
        
        $('#next').click(function(){
            $('.right-container').load('selectPahrma.php',{
                'req': $('.req').val(),
                'docs': $('.docs').val(),
                'pharmacist': $('.pharmas').val(),
                'staff': $('.staff').val(),
            });
        });
        if(docList.length<1)
            $('#next').hide();
        $('#docSelector').on('change',function(e){
            let val = e.target.value;
            if(!docList.includes(val)){
                docList.push(val); 
                $('#next').show();
                console.log(docList);
                document.getElementById("docList").innerHTML = '';
                docList.forEach((val)=> {
                    let l = document.createElement('span');
                    l.setAttribute('class','listItem');
                    let a = document.createElement('button');
                    a.innerHTML = 'x';
                    l.append(a);
                    a.setAttribute('class','listRef btn btn-primary p-2');
                    a.onclick = function(){
                        funcDoc(val);
                    };
                    let text = document.createElement('span');
                    text.innerHTML = val;
                    l.append(text);
                    let docs = document.getElementById("docList");
                    docs.append(l);
                    $('.docs').val(docList.join(','));
                })
            }
        })
        function funcDoc(val){
            console.log('Removing '+val);
            var index = docList.indexOf(val);
            if (index > -1) 
                docList.splice(index, 1);
            if(docList.length==0) $('#next').hide();
            else $('#next').show();
            document.getElementById("docList").innerHTML = '';
            docList.forEach((val)=> {
                let l = document.createElement('span');
                l.setAttribute('class','listItem');
                let a = document.createElement('button');
                a.innerHTML = 'x';
                l.append(a);
                a.setAttribute('class','listRef btn btn-primary p-2');
                a.onclick = function(){funcDoc(val)};
                let text = document.createElement('span');
                text.innerHTML = val;
                l.append(text);
                let docs = document.getElementById("docList");
                docs.append(l);
                $('.docs').val(docList.join(','));
            })
        }
        $('#staffSelector').on('change',function(e){
            let val = e.target.value;
            if(!staffList.includes(val)){
                staffList.push(val); 
                document.getElementById("staffList").innerHTML = '';
                $('#next').show();
                staffList.forEach((val)=> {
                    let l = document.createElement('span');
                    l.setAttribute('class','listItem');
                    let a = document.createElement('button');
                    a.innerHTML = 'x';
                    
                    l.append(a);
                    a.setAttribute('class','listRef btn btn-primary p-2');
                    a.onclick = function(){
                        funcStaff(val);
                    };
                    var text = document.createElement('span');
                    text.innerHTML = val;
                    l.append(text);
                    let docs = document.getElementById("staffList");
                    docs.append(l);
                    $('.staff').val(staffList.join(','));
                })   
            }      
        })
        function funcStaff(val){
            var index = staffList.indexOf(val);
            if (index > -1) 
                staffList.splice(index, 1);
            if(staffList.length==0) $('next').hide();
            else $('next').hide();
            document.getElementById("staffList").innerHTML = '';
            staffList.forEach((val)=> {
                let l = document.createElement('span');
                l.setAttribute('class','listItem');
                let a = document.createElement('button');
                a.innerHTML = 'x';
                l.append(a);
                a.setAttribute('class','listRef btn btn-primary px-2');
                a.onclick = function(){funcStaff(val)};
                let text = document.createElement('span');
                text.innerHTML = val;
                l.append(text);
                let docs = document.getElementById("staffList");
                docs.append(l);
                $('.staff').val(staffList.join(','));
            })
        }
    </script>