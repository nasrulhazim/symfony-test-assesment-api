# API Development

Import Insomnia Request Collection from [here](docs/Insomnia_2024-07-16.json) to test the API.

## Scenario

- **Objective:** Improve customer experience through a personalized recommendation engine that suggests relevant products based on user behavior, purchase history, and product attributes.

## Task

- **Requirement:** Develop a backend API using specified technologies.
- **Key Technologies:**
  - Programming Language: PHP
  - Framework: Symfony Framework
  - Database: MySQL (hosted on Google Cloud Platform)
  - Version Control System: Git
  - API Documentation: Swagger or OpenAPI

## Technical Requirements

### 1. User Management (Security Focus)

- Secure user registration and login.
- Strong password hashing (e.g., bcrypt) and user sessions.
- Input validation and sanitization to prevent SQL injection and XSS vulnerabilities.

### 2. Product Management (Data Modeling)

- Design a robust data model for products using Entity-Relationship Modeling (ERM) principles.
- Include attributes like category, price, description, and additional attributes for future recommendations (e.g., brand, size, color).
- Implement CRUD operations with proper data validation.

### 3. Purchase History (Data Persistence)

- Efficiently persist user purchase data, including product information, timestamps, and quantities purchased.
- Use database normalization techniques to avoid data redundancy.

### 4. Recommendation Engine (Algorithmic Thinking)

- Design and implement a recommendation algorithm that analyzes user purchase history, product attributes, and potentially other factors (e.g., user demographics, browsing behavior).
- Explore collaborative filtering, content-based filtering, or hybrid approaches.
- Consider weighting factors to prioritize relevant recommendations.

### 5. API Design & Scalability (Architecture & Best Practices)

- Structure the API for clarity and future enhancements.
- Implement RESTful principles and use proper HTTP status codes.
- Consider caching mechanisms and database optimization for scalability.

## Bonus Points

- Well-written unit tests covering core functionalities.
- Security measures beyond basic user authentication.
- Implementation of logging and monitoring tools for troubleshooting and performance analysis.
- Design patterns and considerations for future growth.

## Submission

- Submit the code as a zip file or a link to a public Github repository.
- Include a written document outlining your approach and DB schema.

## Additional Notes

- Free to use additional libraries or frameworks with a list included in the submission.
- Comment on your code and document your thought process for better insight.
- Encouraged to ask clarifying questions if needed.

## Outcome

- Demonstrate skills and experience in building and maintaining a robust e-commerce backend system using the specified technologies.
