function createOrderView(parentOrderListId, orderDate, orderType, fromLang, toLang, status, orderId) {
	parentOrderList = document.getElementById(parentOrderListId);
	if (status == 'Выполнен') { //TODO: MAKE A DOWNLOAD BTN WORKING
		orderHtml = `<div class="row order" style="margin:15px; min-width:150px;">
	<div class="col-md-3 col-sm-12"><h3 style="margin: 0;">${orderDate}</h3></div>
	<div class="col-md-3 col-sm-12">${orderType}</br>${fromLang}→${toLang}</div>
	<div class="col-md-3 col sm-12"><h4 style="text-align:center;">${status}</h3></div>
	<div class="col-md-3"><h4><a href="profile.php?downloadTranslation=${orderId}"><span class="icon icon-download"></span></a></h4></div>
</div>`;
	}
	else {
		orderHtml = `<div class="row order" style="margin:15px; min-width:150px;">
	<div class="col-md-3 col-sm-12"><h3 style="margin: 0;">${orderDate}</h3></div>
	<div class="col-md-3 col-sm-12">${orderType}</br>${fromLang}→${toLang}</div>
	<div class="col-md-3 col sm-12"><h4 style="text-align:center;">${status}</h3></div>
	</div>`;
	}
	parentOrderList.innerHTML += orderHtml;
}

function createJobView(jobsListId, orderDate, orderType, fromLang, toLang, status, orderId, statusId) {
	jobList = document.getElementById(jobsListId);
	statusOptions = document.getElementById("statusOptions").innerHTML;
	jobHtml = `<div class="row order" id="${orderId}" style="margin:15px; min-width:150px;">
		<div class="col-md-3 col-sm-12"><h3 style="margin: 0;">${orderDate}</h3></div>
		<div class="col-md-3 col-sm-12">${orderType}</br>${fromLang}→${toLang}</div>
		<div class="col-md-3 col-sm-12"><select class="h4" id="statusSelect${orderId}" onchange="editJob(${orderId}, this.options[this.selectedIndex].label);" style="margin-left: auto; margin-right: auto;">${statusOptions}</select></div>
		<div class="col-md-3 col-sm-12"><h4><a href="profile.php?downloadOrder=${orderId}"><span class="icon icon-download"></span></a></h4></div>
		</div>`;
	jobList.innerHTML += jobHtml;
	statusSelect = document.getElementById(`statusSelect${orderId}`);
	statusSelect.options[statusId - 1].setAttribute("selected", true);
	if (statusId != '1' & statusId != 5) {
		statusSelect.removeChild(statusSelect.options[4]);
	}
	for (let i = 0; i < statusId - 1; i++) {
		statusSelect.removeChild(statusSelect.options[0]);
	}
	if (statusSelect.value > 3) {
		statusSelect.setAttribute("disabled", true);
		statusSelect.style.background = "none";
	}
}

function editJob(orderId, newStatus) {
	if (confirm("Сменить статус заказа на " + newStatus + "?")) {
		if (newStatus == 'Выполнен') {
			document.getElementById('translatedOrderId').value = orderId;
			animateShow('translationInput_overlay');
		}
		else {
			document.getElementById("editOrderId").value = orderId;
			document.getElementById("newStatusId").value = document.getElementById(`statusSelect${orderId}`).value;
			document.getElementById("statusNinja").submit();
		}
	} else {
		setDefaultJobStatus(orderId);
	}
}

function setDefaultJobStatus(orderId) {
	document.getElementById(`statusSelect${orderId}`).selectedIndex = 0;
}

