// const Utils = {
//   months: function({ count }) {
//     return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
//   },
//   CHART_COLORS: {
//     red: 'rgba(255, 99, 132, 0.5)',
//     blue: 'rgba(54, 162, 235, 0.5)',
//     green: 'rgba(75, 192, 192, 0.5)',
//     yellow: 'rgba(255, 205, 86, 0.5)',
//   }
// };

// // Data configuration
// const DATA_COUNT = 7;
// const labels = Utils.months({ count: DATA_COUNT });
// const data = {
//   labels: labels,
//   datasets: [
//     {
//       label: 'Dataset 1',
//       data: [10, 30, 50, 20, 25, 44, -10],  // Values for the chart
//       borderColor: Utils.CHART_COLORS.red,  // Border color for the line
//       backgroundColor: Utils.CHART_COLORS.red,  // Background color (used in tooltip hover)
//       fill: false  // Ensures no filling under the line
//     }
//   ]
// };

// // Chart configuration
// const config = {
//   type: 'line',
//   data: data,
//   options: {
//     responsive: true,  // Ensures responsiveness for the chart
//     plugins: {
//       title: {
//         display: true,
//         text: 'Min and Max Settings'  // Title of the chart
//       }
//     },
//     scales: {
//       y: {
//         min: 10,  // Minimum value for the y-axis
//         max: 50,  // Maximum value for the y-axis
//         beginAtZero: false  // Ensures it doesn't start at 0 but from the 'min' value
//       }
//     }
//   }
// };

// Initialize the chart

