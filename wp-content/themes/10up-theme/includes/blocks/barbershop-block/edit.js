// WordPress dependencies
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, PanelRow, PanelHeader, TextControl, Button, ButtonGroup } from '@wordpress/components';

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
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps();
	const [booking, setBooking] = useState({
		services: [],
		day: '',
		hour: '',
		name: '',
	});

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
		return total + Number(selectedService.price);
	}, 0);

	const handleServiceChange = (index, field, value) => {
		const newServices = [...attributes.services];
		newServices[index][field] = value;
		setAttributes({ services: newServices });
	};

	const handleAddService = () => {
		const newServices = [...attributes.services, { name: '', price: '' }];
		setAttributes({ services: newServices });
	};

	const handleRemoveService = (index) => {
		const newServices = [...attributes.services];
		newServices.splice(index, 1);
		setAttributes({ services: newServices });
	};

	return (
		<div {...blockProps}>
			<h2>{__('Barbershop Booking')}</h2>
			<div className="barbershop-block__step barbershop-block__step--service active">
				<h4 className="barbershop-block__step-title">{__('Choose the type of service')}</h4>
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
					<h4 className="barbershop-block__step-title">{__('Choose a day')}</h4>
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
					<h4 className="barbershop-block__step-title">{__('Choose a timeslot')}</h4>
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
				<div className="barbershop-block__step barbershop-block__step--name active">
					<h4 className="barbershop-block__step-title">{__('And finally, Your name and surname')}</h4>
					<div className="barbershop-block__step-items">
						<TextControl
							className={"barbershop-block__textinput"}
							label={__('Name and Surname')}
							value={booking.name}
							onChange={(value) => setBooking({ ...booking, name: value })}
						/>
					</div>
				</div>
			)}
			{booking.hour && (
				<div className="barbershop-block__step barbershop-block__step--final active">
					<div className="barbershop-block__metadata">
						<span>{__('Total cost: €')}</span>
						<span>{totalCost}</span>
					</div>-
					
					<form>
						<input type="hidden" name="name" value={booking.name} readOnly />
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

			<InspectorControls>
				<PanelBody title={__('Services')}>
					{attributes.services.map((service, index) => (
						<div className="barbershop-block__panelrow" key={index}>
							<PanelRow>
								<TextControl
									label={__('Service Name')}
									value={service.name}
									onChange={(value) => handleServiceChange(index, 'name', value)}
								/>
								<TextControl
									label={__('Price')}
									value={service.price}
									onChange={(value) => handleServiceChange(index, 'price', value)}
								/>
							</PanelRow>
								<ButtonGroup>
									<Button onClick={() => handleRemoveService(index)}>
										{__('Remove')}
									</Button>
								</ButtonGroup>
						</div>
					))}
					<Button onClick={handleAddService}>
						{__('Add Service')}
					</Button>
				</PanelBody>
			</InspectorControls>
		</div>
	);
};

export default BarbershopEdit;
