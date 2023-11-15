/**
 * This file contains the front-end JavaScript for the recipe block.
 */

/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready';

/**
 * Initialize the strikethrough handler which is a function that binds on click events to ingredients and allows interaction with them.
 * This is a front-end only feature.
 *
 * @returns {void}
 */
const _initBarbershopBlock = () => {
	const services = document.querySelectorAll('input[name="services"]');
	const calendarStep = document.querySelector('.barbershop-block__step--calendar');
	const hourStep = document.querySelector('.barbershop-block__step--hour');
	const nameStep = document.querySelector('.barbershop-block__step--name');
	const finalStep = document.querySelector('.barbershop-block__step--final');
	const totalCost = document.querySelector('#total-cost');
	const days = document.querySelectorAll('input[name="day"]');
	const hours = document.querySelectorAll('input[name="hour"]');
	const personName = document.querySelector('input[name="customer"]');

	/**
	 * Get the total cost of the selected services.
	 *
	 * @returns {string} The total cost of the selected services.
	 */
	const getCost = () => {
		const checkedServices = document.querySelectorAll('input[name="services"]:checked');
		let cost = 0;
		checkedServices.forEach((service) => {
			const servicePrice = parseFloat(service.dataset.price, 100);
			cost += servicePrice;
		});
		return cost.toFixed(2);
	};

	/**
	 * Get all services. Watch if none is selected to remove the active steps. We need at least one service to continue with the next steps
	 */
	services.forEach((service) => {
		service.addEventListener('change', () => {
			const checkedServices = document.querySelectorAll('input[name="services"]:checked');
			if (checkedServices.length > 0) {
				calendarStep.classList.add('active');
			} else {
				calendarStep.classList.remove('active');
				hourStep.classList.remove('active');
				nameStep.classList.remove('active');
				finalStep.classList.remove('active');
			}
			totalCost.innerHTML = getCost();
		});
	});

	/**
	 * When a day is clicked, check which one it is and add it to the booking.
	 *
	 */
	days.forEach((day) => {
		day.addEventListener('change', () => {
			hourStep.classList.add('active');
		});
	});

	/**
	 * When an hour is clicked, check which one it is and add it to the booking.
	 */
	hours.forEach((hour) => {
		hour.addEventListener('change', () => {
			nameStep.classList.add('active');
			finalStep.classList.add('active');
			totalCost.innerHTML = getCost();
		});
	});

	/**
	 * Submit the booking to our CPT
	 */
	document.getElementById('barbershop_form').addEventListener('submit', (event) => {
		// Prevent the form from submitting, handle all logic below
		event.preventDefault();

		// If the Person name is empty, don't submit the form
		if (personName.value === '') {
			return;
		}

		const customerName = personName.value;
		const selectedDay = document.querySelector('input[name="day"]:checked').value;
		const selectedHour = document.querySelector('input[name="hour"]:checked').value;
		const checkedServices = document.querySelectorAll('input[name="services"]:checked');
		const bookingDatetime = new Date(`${selectedDay}T${selectedHour}:00Z`);

		let servicesText = '';
		checkedServices.forEach((service) => {
			servicesText += `- ${service.value} - €${service.dataset.price}\n</br>`;
		});

		/**
		 * Format date to be readable by humans.
		 *
		 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date/toLocaleString
		 */
		const readableDatetime = bookingDatetime.toLocaleString('en-US', {
			year: 'numeric',
			month: 'long',
			day: 'numeric',
			hour: 'numeric',
			minute: 'numeric',
			hour12: true,
		});

		/**
		 * Send the booking to the server.
		 *
		 * @see https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
		 */
		fetch('/wp-json/tenup-plugin/v1/bookings', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				title: `${customerName} - ${readableDatetime}`,
				content: `${customerName} has requested the following services:\n${servicesText}`,
				booking_datetime: bookingDatetime.toISOString(),
			}),
		})
			.then((response) => {
				const params = new URLSearchParams({
					status: response.ok ? 'success' : 'fail',
					customer: customerName,
					datetime: bookingDatetime.toISOString(),
					services: servicesText,
				});
				window.location.href = `/status/?${params.toString()}`;
			})
			.catch((error) => {
				console.error('Error:', error); // Generates warning from [eslint], this is intentional here
			});
	});
};

/**
 * Init when DOM is ready.
 */
domReady(async () => {
	_initBarbershopBlock();
});
