// WordPress dependencies
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';

/**
 * Edit component.
 * See https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-edit-save/#edit
 *
 * @param {object}   props                  The block props.
 * @param {object}   props.attributes       Block attributes.
 * @param {string}   props.attributes.title Custom title to be displayed.
 * @param {string}   props.className        Class name for the block.
 * @param {Function} props.setAttributes    Sets the value for block attributes.
 * @returns {Function} Render the edit screen
 */

const BarbershopEdit = (props) => {
	const { attributes } = props;
	const [booking, setBooking] = useState({
		services: [],
		day: '',
		hour: '',
	});

	console.log(booking);

	const currentDate = new Date();
	const daysInMonth = new Date(
		currentDate.getFullYear(),
		currentDate.getMonth() + 1,
		0,
	).getDate();

	const days = Array.from({ length: daysInMonth }, (_, i) => {
		const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), i + 1);
		const isPastDate = date < currentDate;
		return { date, isPastDate };
	});

	const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
	const dayOfWeek = firstDayOfMonth.getDay(); // 0 is Sunday, 1 is Monday, etc.

	const hours = Array.from({ length: 10 }, (_, i) => {
		const hour = 9 + i;
		return `${hour}:00`;
	});

	const handleInputChange = (event) => {
		const { name, value, checked } = event.target;

		console.log(name, value, checked)

		if (name.startsWith('service-')) {
			const serviceName = name.replace('service-', '');
			if (checked) {
				setBooking((prevState) => ({
					...prevState,
					services: [...prevState.services, serviceName],
				}));
			} else {
				setBooking((prevState) => ({
					...prevState,
					services: prevState.services.filter((service) => service !== serviceName),
				}));
			}
		} else {
			setBooking((prevState) => ({
				...prevState,
				[name]: value,
			}));
		}
	};

	const totalCost = booking.services.reduce((total, service) => {
		const selectedService = attributes.services.find((s) => s.name === service);
		return total + selectedService.price;
	}, 0);

	return (
		<div {...props}>
			<h2>{__('Barbershop Booking')}</h2>
			<div className="barbershop-block__step barbershop-block__step--service active">
				<h4>{__('Choose the type of service')}</h4>
				<div className="barbershop-block__step-items">
					{attributes.services.map((service) => (
						<label key={service.name}>
							<input
								type="checkbox"
								name={`service-${service.name}`}
								value={service.name}
								checked={booking.services.includes(service.name)}
								onChange={handleInputChange}
							/>
							<span>
								{__(service.name)} - €{service.price}
							</span>
						</label>
					))}
				</div>
			</div>
			{booking.services.length > 0 && (
				<div className="barbershop-block__step barbershop-block__step--calendar active">
					<h4>{__('Choose a day')}</h4>
					<div className="barbershop-block__calendar--hint">
						<p>Monday</p>
						<p>Tuesday</p>
						<p>Wednesday</p>
						<p>Thursday</p>
						<p>Friday</p>
						<p>Saturday</p>
						<p>Sunday</p>
					</div>
					<div className="barbershop-block__step-items" data-startday={dayOfWeek}>
						{days.map(({ date, isPastDate }) => (
							<label key={date}>
								<input
									type="radio"
									name="day"
									value={date.toLocaleDateString()}
									checked={
										booking.day &&
										new Date(booking.day).toLocaleDateString() ===
											date.toLocaleDateString()
									}
									onChange={handleInputChange}
									disabled={isPastDate}
								/>
								<span className={isPastDate ? 'past-date' : ''}>
									{date.toLocaleDateString('en-GB', { day: 'numeric' })}
								</span>
							</label>
						))}
					</div>
				</div>
			)}
			{booking.day && (
				<div className="barbershop-block__step barbershop-block__step--hour active">
					<h4>{__('Choose a timeslot')}</h4>
					<div className="barbershop-block__step-items">
						{hours.map((hour) => (
							<label key={hour}>
								<input
									type="radio"
									name="hour"
									value={hour}
									checked={booking.hour === hour}
									onChange={handleInputChange}
								/>
								<span>{__(hour)}</span>
							</label>
						))}
					</div>
				</div>
			)}
			{booking.hour && (
				<div className="barbershop-block__step barbershop-block__step--final active">
					<div className="barbershop-block__metadata">
						<span>{__('Total cost: $')}</span>
						<span>{totalCost}</span>
					</div>
					
					<form>
						{booking.services.map((service) => (
							<input key={service} type="hidden" name="services[]" value={service} />
						))}
						<input type="hidden" name="day" value={booking.day} />
						<input type="hidden" name="hour" value={booking.hour} />
						<button className="button button__primary" type="submit">
							{__('Book Now')}
						</button>
					</form>
				</div>
			)}
		</div>
	);
};

export default BarbershopEdit;
