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
	const personName = document.querySelector('input[name="person_name"]');
	const submit = document.querySelector('button.button__primary');

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
				nameStep.classList.remove('active');
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
			nameStep.classList.add('active');
			finalStep.classList.add('active');
			totalCost.innerHTML = getCost();
		});
	});

	console.log(services);

	submit.addEventListener('click', () => {
		const customerName = personName.value;
		const selectedDay = document.querySelector('input[name="day"]:checked').value;
		const selectedHour = document.querySelector('input[name="hour"]:checked').value;
		const bookingDatetime = new Date(`${selectedDay}T${selectedHour}`);

		const checkedServices = document.querySelectorAll('input[name="services"]:checked');
		let servicesText = '';
		checkedServices.forEach((service) => {
			servicesText += `- ${service.value} - €${service.dataset.price}\n`;
		});
		
		// Format date without milliseconds and adjust time zone
		const formattedDatetime = bookingDatetime.toISOString().slice(0, -5);
		
		const readableDatetime = bookingDatetime.toLocaleString('en-US', {
			year: 'numeric', 
			month: 'long', 
			day: 'numeric', 
			hour: 'numeric', 
			minute: 'numeric', 
			hour12: true 
		});

		// REST API endpoint was created for this, see Bookings.php
		fetch('/wp-json/tenup-plugin/v1/bookings', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				title: `${customerName} - ${readableDatetime}`,
				content: `${customerName} has requested the following services:\n${servicesText}`,
				booking_datetime: formattedDatetime,
			}),
		})
		.then(response => {
			if (response.ok) {
				window.location.href = '/success/';
			} else {
				window.location.href = '/fail/';
			}
		})
		.catch(error => {
			console.error('Error:', error);
			window.location.href = '/fail/';
		});
	});
};

/**
 * Init when DOM is ready.
 */
domReady(async () => {
	_initBarbershopBlock();
});