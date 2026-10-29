# PHP & Yii2 System Design: SOLID Guided by DRY, KISS, and YAGNI

## Introduction

When developing applications using PHP and the Yii2 Framework, software design should prioritize:
- **Simplicity** — Easy to understand and modify
- **Maintainability** — Long-term sustainability and evolution
- **Readability** — Clear code that tells its intent
- **Consistency** — Adherence to framework conventions

### SOLID vs. Pragmatism

The SOLID principles provide useful guidance for structuring object-oriented applications. However, applying them too rigidly can introduce:
- Unnecessary abstractions
- Excessive class hierarchies
- Additional maintenance costs

### Core Philosophy

**Follow Yii2 conventions first.** Introduce additional architectural patterns only when the application's complexity justifies them.

SOLID should always be guided by three foundational principles:
- **DRY** — Avoid duplicating knowledge and business logic
- **KISS** — Prefer the simplest solution that adequately solves the problem
- **YAGNI** — Implement abstractions and features only when they are actually needed

---

## The Foundational Guardrails
### 1. DRY (Don't Repeat Yourself)

**Concept:** Every piece of knowledge or business logic should have a single, authoritative representation within the application.

#### Application in PHP & Yii2

Avoid duplicating:
- Validation rules
- Database queries
- Business calculations
- Application behavior across controllers, models, and views

#### Centralization Mechanisms

Use Yii2's existing mechanisms to centralize reusable logic:

| Mechanism | Purpose |
|-----------|---------|
| `rules()` | Model validation rules |
| `scenarios()` | Context-dependent validation |
| Relations | Model associations |
| Query scopes | Reusable database queries |
| Services | Business operations across entry points |
| Components | Reusable application capabilities |
| Helpers | Small, stateless utility functions |
| Traits | Narrowly scoped behavior (when composition isn't suitable) |

#### Example: Centralizing Reusable Queries

**BAD** — The same query is repeated across controllers:

```php
$activeUsers = User::find()
    ->where(['status' => User::STATUS_ACTIVE])
    ->all();
```

**GOOD** — Define reusable query behavior:

```php
class UserQuery extends \yii\db\ActiveQuery
{
    public function active(): self
    {
        return $this->andWhere([
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}

class User extends \yii\db\ActiveRecord
{
    public static function find(): UserQuery
    {
        return new UserQuery(static::class);
    }
}

// Usage:
$activeUsers = User::find()->active()->all();
```

#### Important Caveat

**DRY does not mean every similar-looking code fragment must be extracted.**

Two pieces of code may look similar while representing **different business rules**. Prematurely combining them introduces unnecessary coupling.

**Guideline:** Extract shared logic when it represents the **same knowledge or behavior**, not merely because the code looks similar.

---

### 2. KISS (Keep It Simple, Stupid)

**Concept:** Software should remain as simple as possible while satisfying its functional requirements.

#### Application in PHP & Yii2

Yii2 already provides many architectural building blocks. **Prefer using them directly** before introducing custom layers.

**Use:**
- `ActiveRecord` for ordinary database operations
- `ActiveQuery` for reusable query conditions
- `Model` for forms and input validation
- Yii2 validators instead of custom validation logic
- Framework behaviors and events when appropriate
- Yii2's built-in dependency injection container

#### Example: Simple Data Retrieval

**GOOD** — Straightforward Yii2 ActiveRecord usage:

```php
$user = User::findOne($id);

if ($user === null) {
    throw new NotFoundHttpException('User not found.');
}
```

For this simple operation, creating a `UserRepositoryInterface`, `UserRepository`, and `UserService` introduces **unnecessary complexity**.

A separate service should be introduced **only** when it provides measurable benefit:
- Encapsulating complex business operations
- Managing persistence behavior
- Coordinating multiple models

**Guideline:** Do not recreate functionality that Yii2 already provides effectively.

---

### 3. YAGNI (You Aren't Gonna Need It)

**Concept:** Implement functionality when there is a demonstrated requirement, not merely because it might be useful in the future.

#### Application in PHP & Yii2

Avoid introducing architectural components without a clear purpose.

#### Examples of Unnecessary Abstractions

- Creating repository interfaces for every ActiveRecord model
- Creating service classes that only delegate one method call
- Introducing factories for objects that can be instantiated directly
- Building generic CRUD frameworks for small applications
- Creating event-driven workflows for straightforward synchronous operations
- Adding interfaces for classes with only one implementation

#### Example

**GOOD** — A simple operation doesn't always need a service:

```php
$user = new User();
$user->name = $name;
$user->email = $email;

if (!$user->save()) {
    // Handle validation or persistence failure.
}
```

When the operation develops additional responsibilities (coordinating multiple models, transactions, notifications, external integrations), a service becomes appropriate.

**Guideline:** Add complexity in response to actual requirements, not hypothetical future scenarios.

---

## The Balancing Act: SOLID vs. KISS and YAGNI
SOLID, KISS, and YAGNI are complementary principles, but they can sometimes compete.

**Example:** Strictly applying the Dependency Inversion Principle might encourage interfaces for every service. However, a typical Yii2 CRUD application may not need such abstractions.

#### Simple CRUD Example

```php
class UserController extends Controller
{
    public function actionView(int $id): string
    {
        $user = User::findOne($id);

        if ($user === null) {
            throw new NotFoundHttpException('User not found.');
        }

        return $this->render('view', ['model' => $user]);
    }
}
```

This implementation is **perfectly acceptable** for straightforward CRUD. Introducing additional layers merely to satisfy a pattern may make the application harder to understand.

#### Complex Workflow Example

Suppose user registration eventually requires:
1. Validating registration information
2. Creating a user account
3. Assigning a default role
4. Recording an audit log
5. Sending a confirmation email

At this point, moving into a dedicated service becomes **reasonable**.

### The Golden Rule

> **Start with KISS and YAGNI.** Apply DRY when genuine duplication emerges. Introduce SOLID-based abstractions when responsibilities, dependencies, or variations become sufficiently complex to justify them. Refactor incrementally while preserving existing behavior.

---

## The SOLID Principles
### 1. Single-Responsibility Principle (SRP)

**Definition:** A class should have one primary responsibility and one reason to change.

#### Application in PHP & Yii2

Yii2 provides different classes for different responsibilities:

| Component | Primary Responsibility |
|-----------|------------------------|
| Controller | Handle HTTP requests, coordinate operations, return responses |
| Model | Represent input, validation rules, or domain data |
| ActiveRecord | Represent and persist database records |
| ActiveQuery | Encapsulate reusable database query behavior |
| Service | Coordinate business operations and workflows |
| Component | Provide reusable application-level capabilities |
| View | Render presentation output |

These are **guidelines, not rigid boundaries**.

#### Example: Separating Business Logic from Controllers

**BAD** — Controller handles HTTP, business logic, and email:

```php
class OrderController extends Controller
{
    public function actionCreate()
    {
        $order = new Order();
        $order->load(Yii::$app->request->post());

        if ($order->save()) {
            Yii::$app->mailer
                ->compose('order-confirmation', ['order' => $order])
                ->setTo($order->customer_email)
                ->send();

            return $this->redirect(['view', 'id' => $order->id]);
        }

        return $this->render('create', ['model' => $order]);
    }
}
```

The controller mixes request handling and email delivery.

**GOOD** — Service separates concerns:

```php
class OrderService
{
    public function create(Order $order): bool
    {
        if (!$order->save()) {
            return false;
        }

        // Notify customer after persistence succeeds.
        // Delivery failures should have an explicit policy.

        return true;
    }
}

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(
        $id,
        $module,
        OrderService $orderService,
        $config = []
    ) {
        $this->orderService = $orderService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $order = new Order();

        if (
            $order->load(Yii::$app->request->post())
            && $this->orderService->create($order)
        ) {
            return $this->redirect(['view', 'id' => $order->id]);
        }

        return $this->render('create', ['model' => $order]);
    }
}
```

#### Yii2 Considerations

- Keep request parsing and response generation in controllers
- Keep validation rules close to the model
- Use services for meaningful business workflows
- Avoid putting unrelated operations into ActiveRecord methods
- Avoid creating a service for every controller action

**Guideline:** Separate responsibilities when doing so improves clarity, reuse, or testability.

---

### 2. Open-Closed Principle (OCP)

**Definition:** Software components should be **open for extension but closed for modification**.

New behavior should be introduced through extension points without repeatedly changing stable logic.

#### Application in PHP & Yii2

Extension mechanisms:
- PHP interfaces
- Inheritance and composition
- Yii2 components, behaviors, and events

Abstractions should be introduced **only** when multiple implementations are required or reasonably established.

#### Example: Multiple Notification Channels

**Define the contract:**

```php
interface NotificationInterface
{
    public function send(string $recipient, string $message): bool;
}
```

**Implement email:**

```php
class EmailNotification implements NotificationInterface
{
    public function send(string $recipient, string $message): bool
    {
        return Yii::$app->mailer
            ->compose()
            ->setTo($recipient)
            ->setSubject('Notification')
            ->setTextBody($message)
            ->send();
    }
}
```

**Create a service:**

```php
class NotificationService
{
    private NotificationInterface $notification;

    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function notify(string $recipient, string $message): bool
    {
        return $this->notification->send($recipient, $message);
    }
}
```

**Add SMS without modifying existing code:**

```php
class SmsNotification implements NotificationInterface
{
    public function send(string $recipient, string $message): bool
    {
        // Integrate with SMS provider.
        return true;
    }
}
```

`NotificationService` doesn't need to know which channel is used.

#### Yii2 Considerations

- Use interfaces when implementations genuinely vary
- Prefer composition over deep inheritance
- Use Yii2 behaviors for reusable model/component behavior
- Use events for appropriate extension points without obscuring workflows
- Avoid introducing extensibility for hypothetical features

**Guideline:** Design extension points around **demonstrated variation**, not speculative requirements.

---

### 3. Liskov Substitution Principle (LSP)

**Definition:** A subclass or implementation should be usable wherever its parent class or interface is expected, without violating the established behavioral contract.

#### Application in PHP & Yii2

Classes extending Yii2 framework components should preserve expected behavior. This is particularly important when overriding:
- `yii\db\ActiveRecord`
- `yii\base\Model`
- `yii\web\Controller`
- `yii\base\Component`
- `yii\db\ActiveQuery`

#### Example: Overriding ActiveRecord Behavior

**BAD** — Subclass changes the meaning of `save()`:

```php
class User extends ActiveRecord
{
    public function save($runValidation = true, $attributeNames = null)
    {
        // Pretends persistence succeeded.
        return true;
    }
}
```

Other code expects `save()` to follow Yii2's persistence contract. Returning true without saving violates that expectation.

**GOOD** — Extend behavior while preserving the contract:

```php
class User extends ActiveRecord
{
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert && $this->created_at === null) {
            $this->created_at = time();
        }

        return true;
    }
}
```

#### Yii2 Considerations

- Respect parent method signatures and return contracts
- Call parent lifecycle methods when required
- Do not silently change expected persistence behavior
- Preserve validation and error-reporting semantics
- Avoid inheritance when subclasses require incompatible behavior

For example, extending `ActiveRecord` merely to reuse utility methods is inappropriate. Use composition, helpers, or traits instead.

**Guideline:** Inheritance should preserve behavioral compatibility, not merely provide code reuse.

---

### 4. Interface Segregation Principle (ISP)

**Definition:** Classes should not be forced to implement methods they do not need.

Prefer small interfaces representing meaningful capabilities over large interfaces with unrelated operations.

#### Application in PHP & Yii2

Interfaces are useful when different components require different capabilities.

#### Example: Separating Read and Write Operations

**BAD** — Every implementation must support both operations:

```php
interface DataRepositoryInterface
{
    public function find(int $id);
    public function save($model): bool;
    public function delete(int $id): bool;
    public function export(): array;
}
```

A reporting component might only need read access; an export component only needs export. Create focused interfaces:

**GOOD** — Separate capabilities:

```php
interface UserReaderInterface
{
    public function findById(int $id): ?User;
}

interface UserWriterInterface
{
    public function save(User $user): bool;
}

class UserRepository implements UserReaderInterface, UserWriterInterface
{
    public function findById(int $id): ?User
    {
        return User::findOne($id);
    }

    public function save(User $user): bool
    {
        return $user->save();
    }
}
```

A component requiring only read access depends on `UserReaderInterface`.

#### Important Yii2 Consideration

This example demonstrates ISP, but **not every Yii2 application needs a repository layer**.

For straightforward applications, using `ActiveRecord` directly is often simpler.

Separate interfaces become valuable when:
- Multiple implementations exist
- Persistence is complex
- Application modules require distinct capabilities
- External systems must be integrated
- Testing benefits from replacing a dependency

**Guideline:** Keep interfaces focused, but introduce them only when they establish a useful architectural boundary.

---

### 5. Dependency Inversion Principle (DIP)

**Definition:** High-level business logic should not depend directly on low-level implementation details. Both should depend on appropriate abstractions.

#### Application in PHP & Yii2

Yii2 provides a dependency injection container that resolves and configures dependencies.

Dependency injection is useful when business logic depends on interchangeable components:
- Payment gateways
- External APIs
- Notification providers
- Storage backends
- Complex data access implementations

#### Example: Payment Processing

**Define the contract:**

```php
interface PaymentGatewayInterface
{
    public function charge(int $amount, string $reference): bool;
}
```

**Create business logic:**

```php
class PaymentService
{
    private PaymentGatewayInterface $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function process(int $amount, string $reference): bool
    {
        return $this->gateway->charge($amount, $reference);
    }
}
```

**Implement a concrete gateway:**

```php
class BankPaymentGateway implements PaymentGatewayInterface
{
    public function charge(int $amount, string $reference): bool
    {
        // Integrate with bank's payment API.
        return true;
    }
}
```

**Configure with Yii2's container:**

```php
// config/web.php
return [
    'container' => [
        'definitions' => [
            PaymentGatewayInterface::class => BankPaymentGateway::class,
        ],
    ],
];
```

**Resolve through Yii2:**

```php
$paymentService = Yii::createObject(PaymentService::class);
```

The business service depends on a contract, not a specific provider. The implementation can change without modifying `PaymentService`.

#### Yii2 Considerations

- Prefer constructor injection for required dependencies
- Use container definitions for interchangeable implementations
- Avoid unnecessary service locators inside domain logic
- Do not introduce interfaces for every class
- Keep framework configuration explicit and understandable

Direct access to `Yii::$app` is acceptable in framework-facing code, but excessive reliance on global components inside business services makes dependencies harder to identify and test.

**Guideline:** Use dependency inversion where implementation independence provides practical value.

---

## Practical Architecture Guidelines for Yii2
A maintainable Yii2 application does not require a complex architecture from the beginning.

A reasonable structure for an application with growing business complexity:

```
common/
├── components/
├── models/
│   ├── User.php
│   └── Order.php
├── queries/
│   └── UserQuery.php
├── services/
│   ├── OrderService.php
│   └── PaymentService.php
└── interfaces/
    └── PaymentGatewayInterface.php

frontend/
├── controllers/
├── models/
└── views/

backend/
├── controllers/
├── models/
└── views/

console/
├── controllers/
└── migrations/
```

This is an **illustrative Yii2 Advanced Application structure**, not a mandatory layout. Directories should be introduced as responsibilities emerge.

### 1. Controllers

Controllers should focus on:
- Handling HTTP requests
- Performing access checks
- Loading and validating request input
- Invoking business operations
- Returning responses or rendering views

**Avoid** embedding:
- Complex business workflows
- Extensive database operations
- External API integrations

### 2. Models and ActiveRecord

Use Yii2 models for their intended responsibilities:

| Type | Purpose |
|------|---------|
| `yii\base\Model` | Form inputs, validation, data transfer |
| `yii\db\ActiveRecord` | Database-backed entities and persistence |
| `yii\db\ActiveQuery` | Reusable query behavior |

`ActiveRecord` can contain business behavior directly related to the entity. However, operations coordinating multiple models or external systems may belong in a service.

### 3. Services

Introduce services when business operations become complex enough to justify separation.

**Typical examples:**
- Order processing
- Payment workflows
- User registration
- Inventory adjustments
- Transactional operations across multiple models
- Integration with external providers

A service should encapsulate **meaningful business behavior**, not merely forward method calls.

### 4. Database Transactions

Use Yii2 database transactions when multiple database changes must succeed or fail together:

```php
$transaction = Yii::$app->db->beginTransaction();

try {
    $order->save(false);

    foreach ($items as $item) {
        $item->order_id = $order->id;
        $item->save(false);
    }

    $transaction->commit();
} catch (\Throwable $e) {
    $transaction->rollBack();
    throw $e;
}
```

**Important:** This example assumes all models are already validated. Production code should check persistence results and handle failures explicitly; `save(false)` skips validation and does not guarantee every failure throws an exception.

Use transactions to protect operations requiring atomicity. Avoid transactions around unrelated database operations or external API calls unless consistency requirements are clearly understood.

### 5. Framework Conventions

Follow Yii2 conventions whenever practical:
- Use `rules()` for model validation
- Use `scenarios()` for context-specific validation
- Use relations for model associations
- Use `ActiveQuery` for reusable queries
- Use `behaviors()` for appropriate cross-cutting behavior
- Use migrations for database schema changes
- Use application components for shared infrastructure services
- Use dependency injection where multiple implementations or testability justify it

**Avoid** rebuilding functionality already available in the framework.

---

## Decision Guide: When Should You Introduce an Abstraction?

| Situation | Recommended Approach | Primary Principle |
|-----------|---------------------|------------------|
| Simple CRUD operation | Controller + ActiveRecord | KISS |
| Repeated validation rules | Model validation rules | DRY |
| Repeated database filters | ActiveQuery methods | DRY |
| Complex business workflow | Dedicated service | SRP |
| Multiple payment providers | Interface + implementations | OCP, DIP |
| Shared model behavior | Behavior, composition, or trait | DRY, SRP |
| Multiple database changes requiring atomicity | Database transaction | Consistency |
| Single ActiveRecord implementation | Use directly | YAGNI |
| Unrelated methods in large interface | Split into focused interfaces | ISP |
| Subclass changes expected parent behavior | Redesign inheritance or composition | LSP |
| Potential future feature (no current need) | Do not implement yet | YAGNI |

---

## Testing and Refactoring Guidelines

Good software design should make application behavior easier to verify.

### For Yii2 Applications

1. **Unit tests** — Business logic that can be tested independently
2. **Integration tests** — ActiveRecord persistence, transactions, and database behavior
3. **Model tests** — Validation rules and important scenarios
4. **Controller tests** — Routing, authorization, HTTP responses when important
5. **Mock external services** — At meaningful dependency boundaries
6. **Preserve existing behavior** — When refactoring
7. **Avoid architectural changes** — Without corresponding verification

Tests should focus on **observable behavior and business requirements** rather than internal implementation details.

**Important:** Code that is easy to test is desirable, but testability alone does not justify introducing unnecessary layers throughout the application.

---

## Final Engineering Principles

When developing with PHP and Yii2, follow these principles **in order:**

1. **Follow Yii2 conventions** — Use the framework's established architecture and built-in capabilities
2. **Keep implementation simple** (KISS) — Favor readable, straightforward solutions
3. **Avoid speculative features** (YAGNI) — Build only what current requirements justify
4. **Eliminate duplicated knowledge** (DRY) — Centralize genuinely shared business rules and behavior
5. **Separate responsibilities** (SRP) — Keep unrelated concerns from accumulating in a single class
6. **Introduce extensibility** (OCP) — Prefer deliberate extension points over speculative abstractions
7. **Preserve behavioral contracts** (LSP) — Respect expectations established by parent classes and interfaces
8. **Keep interfaces focused** (ISP) — Depend only on capabilities a component requires
9. **Invert dependencies** (DIP) — Isolate business logic from interchangeable infrastructure implementations
10. **Refactor incrementally** — Improve architecture as requirements evolve while maintaining verified behavior

### The Golden Rule

> **Simple first.** Follow Yii2 conventions. Abstract when necessary. Refactor when justified.
>
> SOLID principles are tools for managing complexity, not requirements to introduce complexity.
>
> A well-designed Yii2 application is not defined by the number of services, repositories, interfaces, or design patterns it contains.
>
> **It is defined by how clearly its responsibilities are organized, how reliably it behaves, and how easily developers can understand, test, maintain, and extend it.**