// Simulate async backend request
setTimeout(() => {
  renderCategories(backendCategories);
}, 300); // simulate 0.3s network delay
