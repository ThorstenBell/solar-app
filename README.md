## Assignment: Solar Installation Monitoring Tool

### Set up
`npm install`
`composer install`

### Run
`npm run build`
`php artisan serve`
[http://127.0.0.1:8000/](http://127.0.0.1:8000/)

### Tests
`npm run test`
`php artisan test`

### Choices
- I chose to have installations and measurements as separate tables because I wanted to be able to add more measurements to a single installation.
- I used chart.js for the charts because it is easy to use and has a lot of options.

### Differences Production
- In production, the app uses a MySQL or PostgreSQL database instead of SQLite
- In production, the app uses a different .env file

### Future possibilities
- Write better and more tests
- Fix chart rendering after data update
- Form validation
- Default values for the measurements
- Predictions based on the measurements
- Add authentication
- Put Edit & Create forms in modals
- Add more fields to the solar installation
  - Location
  - Type of solar panels
  - Number of solar panels
  - etc.
- Show more charts
  - Total energy produced
  - Total energy consumed
  - Net energy
- Add filters to a single chart
- Add sorting to the tables
- Add filtering to the tables
- Add pagination to the tables
- Make tables responsive
