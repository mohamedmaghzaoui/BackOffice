// skill.js file

document.addEventListener('DOMContentLoaded', function() {
    console.log("this is skill test");

    const skillTable = document.getElementById("skillTable");
    const skillList = document.getElementById("skillList");
    const displaySelector = document.getElementById("displaySelector");

    // Initial hide/show based on the default selection
    toggleDisplay();

    // Add an event listener to the dropdown change
    if (displaySelector) {
        displaySelector.addEventListener('change', toggleDisplay);
    }

    function toggleDisplay() {
        // Hide both elements initially
        if (skillTable) {
            skillTable.style.display = 'none';
        }

        if (skillList) {
            skillList.style.display = 'none';
        }

        // Show the selected element based on the dropdown value
        const selectedOption = displaySelector.value;

        if (selectedOption === 'table' && skillTable) {
            skillTable.style.display = 'table';  // or 'block' based on your styling
        } else if (selectedOption === 'list' && skillList) {
            skillList.style.display = 'block';  // or any other suitable display value
        }
    }
});
