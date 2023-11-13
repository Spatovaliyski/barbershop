(function () {
	const _initBarbershopBlock = () => {
		const services = document.querySelectorAll('input[name="services"]');
		const calendarStep = document.querySelector('.barbershop-block__step--calendar');
		const hourStep = document.querySelector('.barbershop-block__step--hour');
		const finalStep = document.querySelector('.barbershop-block__step--final');
		const totalCost = document.querySelector('#total-cost');
		const days = document.querySelectorAll('input[name="day"]');
		const hours = document.querySelectorAll('input[name="hour"]');

		const getCost = () => {
			const checkedServices = document.querySelectorAll('input[name="services"]:checked');
			let cost = 0;
			checkedServices.forEach((service) => {
				const servicePrice = parseInt(service.dataset.price, 10);
				cost += servicePrice;
			});
			return cost;
		};

		services.forEach((service) => {
			service.addEventListener('change', () => {
				const checkedServices = document.querySelectorAll('input[name="services"]:checked');
				if (checkedServices.length > 0) {
					calendarStep.classList.add('active');
				} else {
					calendarStep.classList.remove('active');
					hourStep.classList.remove('active');
					finalStep.classList.remove('active');
				}
				totalCost.innerHTML = getCost();
			});
		});

		days.forEach((day) => {
			day.addEventListener('change', () => {
				hourStep.classList.add('active');
			});
		});

		hours.forEach((hour) => {
			hour.addEventListener('change', () => {
				finalStep.classList.add('active');
				totalCost.innerHTML = getCost();
			});
		});
	};

	const _init = () => {
		_initBarbershopBlock();
	};

	_init();
})();
