

//scanner for vehicle
var Vscanner = new Instascan.Scanner({ video: document.getElementById('preview1'), scanPeriod: 5, mirror: false });
Vscanner.addListener('scan', function (content) {
    //do something// search for the scanned qr code in tbl_vehicle
    vehicleInfo(content);
});
//scan vehicle
function scanVehicle() {
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            Vscanner.start(cameras[0]);
            $('[name="options"]').on('change', function () {
                if ($(this).val() == 1) {
                    if (cameras[0] != "") {
                        Vscanner.start(cameras[0]);
                    }
                    else {
                        alert('No Front Camera Found');
                    }
                }
                else if ($(this).val() = 2) {
                    if (cameras[1] != "") {
                        Vscanner.start(cameras[1]);
                    }
                    else {
                        alert('No Back Camera Found');
                    }
                }
            });
        }
        else {
            alert('No Camera Found');
        }
    }).catch(function (e) {
        alert(e);
    });
    document.getElementById("vscanner").style.display = "block";
    document.getElementById("vChoose").style.display = "none";
    document.getElementById("manualInputOrcr").style.display = "block";
    document.getElementById("closeVscan").style.display = "block";
    document.getElementById("manualInputForm").style.display = "none";
}
//rescan vehicle funtion
function rescanVehicle() {
    scanVehicle();
    document.getElementById("orcr").style.display = "none";
    document.getElementById("startVscan").style.display = "none";
    document.getElementById("plateNumInput").style.display = "none";

}

//close vehicle scanner
function scanVclose() {
    document.getElementById("vscanner").style.display = "none";
    document.getElementById("vChoose").style.display = "block";
    document.getElementById("manualInputOrcr").style.display = "none";
    document.getElementById("closeVscan").style.display = "none";
    document.getElementById("plateNumInput").style.display = "none";
    document.getElementById("orcr").style.display = "none";
    document.getElementById("startVscan").style.display = "none";
    Vscanner.stop();
}

//button for manual input
function btnManualInputForm() {
    scanVclose();
    document.getElementById("startVscan").style.display = "block";
    document.getElementById("vscanner").style.display = "none";
    document.getElementById("vChoose").style.display = "none";
    document.getElementById("manualInputOrcr").style.display = "none";
    document.getElementById("manualInputForm").style.display = "block";
    document.getElementById("plateNumInput").style.display = "block";

}
//confirm inputted plate num
function btnConfirmPlate() {
    var plate = document.getElementById('plateNum').value;
    console.log(plate);
    vehicleInfo(plate);

}
//function for getting vehicle infos
function vehicleInfo(plateNum) {

    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from tbl_vehicle where plateNumber = '" + plateNum + "'");
    Http.send();
    Http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(Http.responseText);
            if (isEmpty(result)) {
                alert("Plate Number Doesn't Exist");
            } else {

                //hide and show of things.s.s.s.s........
                document.getElementById("plateNumInput").style.display = "none";
                document.getElementById("vscanner").style.display = "none";
                document.getElementById("orcr").style.display = "block";
                document.getElementById("manualInputForm").style.display = "none";
                document.getElementById("manualInputOrcr").style.display = "none";
                document.getElementById("startVscan").style.display = "none";
                document.getElementById("closeVscan").style.display = "block";
                //put data on the ID for the lbl fields in summary
                document.getElementById("txtPlateNumber").value = result[0].plateNumber;
                document.getElementById("txtChassisNumber").value = result[0].chassisNumber;
                document.getElementById("txtEngineNumber").value = result[0].engineNumber;
                document.getElementById("txtFileNumber").value = result[0].fileNumber;
                document.getElementById("txtRegisteredOwner").value = result[0].registeredOwner;

                document.getElementById("btnmodalConfirm").disabled = false;

            }
        }
    }
}
//scanner for user confirmation
var Dscanner = new Instascan.Scanner({ video: document.getElementById('preview2'), scanPeriod: 5, mirror: false });
Dscanner.addListener('scan', function (content) {
    if (content.localeCompare(document.getElementById("txtlicense").value) == 0) {
        alert("The data has been successfully submitted");
        document.getElementById("confirmationForm").submit();
    }

    else
        alert("invalid QR code");
});
//close driver scan
function closedcScan() {
    document.getElementById("modalSummary").style.display = "block";
    document.getElementById("confirmationQR").style.display = "none";
    document.getElementById("confirmationPass").style.display = "none";
    Dscanner.stop();
}

function confirmViolation() {
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            Dscanner.start(cameras[0]);
            $('[name="options"]').on('change', function () {
                if ($(this).val() == 1) {
                    if (cameras[0] != "") {
                        Dscanner.start(cameras[0]);
                    }
                    else {
                        alert('No Front Camera Found');
                    }
                }
                else if ($(this).val() = 2) {
                    if (cameras[1] != "") {
                        Dscanner.start(cameras[1]);
                    }
                    else {
                        alert('No Back Camera Found');
                    }
                }
            });
        }
        else {
            alert('No Camera Found');
        }
    }).catch(function (e) {
        alert(e);
    });
    document.getElementById("modalSummary").style.display = "none";
    document.getElementById("confirmationQR").style.display = "block";
}

function enterPassword() {
    Dscanner.stop();
    document.getElementById("confirmationQR").style.display = "none";
    document.getElementById("confirmationPass").style.display = "block";
}

function modalConfirm() {
    document.getElementById("txtmP_Apprehension").value = document.getElementById("txtP_Apprehension").value;
    document.getElementById("txtmlicense").value = document.getElementById("txtlicense").value;
    document.getElementById("txtmC_items").value = document.getElementById("txtC_items").value;
    var i;
    for (i = 1; i <= 5; i++) {
        if (document.getElementById("violation1_" + i).checked)
            document.getElementById("mviolation1_" + i).checked = true;
    }
    for (i = 1; i <= 3; i++) {
        if (document.getElementById("violation2_" + i).checked)
            document.getElementById("mviolation2_" + i).checked = true;
    }
    for (i = 1; i <= 4; i++) {
        if (document.getElementById("violation3_" + i).checked)
            document.getElementById("mviolation3_" + i).checked = true;
    }
}
//for driver image confirmation
function confirmDriver() {
    document.getElementById('divImage').style.display = "none";
    document.getElementById('driverInfo').style.display = "block";
}


function addViolation() {
    document.getElementById('apprehensionReport').style.display = "block";
    document.getElementById('driverInfo').style.display = "none";
}

function submitReport() {
    var licnum = document.getElementById("txtlicense").value;
    var pass = document.getElementById("txtpassw").value;
    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from tbl_userdriver where licenseNumber = '" + licnum + "'");
    Http.send();
    Http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(Http.responseText);
            if (pass.localeCompare(result[0].password) != 0) {
                const div = document.createElement('div');
                div.innerHTML = `
                <div class="alert alert-danger" role="alert">
                Incorrect Password!
                </div>`;
                document.getElementById('loginalert').appendChild(div);

                setTimeout(function () {
                    $(".alert").alert('close');
                }, 2000);
            }
            else {
                document.getElementById("confirmationForm").submit();
            }
        }
    }
}
function isEmpty(obj) {
    for (var prop in obj) {
        if (obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}