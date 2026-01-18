<react-native-guidelines>
=== foundation rules ===

# React Native Guidelines

These guidelines are specifically curated for this application. These guidelines should be followed closely to enhance the user's satisfaction building React Native applications.

## Foundational Context
This application is a React Native application built with Expo and its main packages & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- react - 19.1.0
- react-native - 0.81.5
- expo - ~54.0.30
- expo-router - ~6.0.21
- typescript - ~5.9.3
- tailwindcss - ^4.1.18
- @react-navigation/native - ^7.1.26
- lucide-react-native - ^0.545.0
- expo-secure-store - ~15.0.8

## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Component files use kebab-case (e.g., `user-profile.tsx`), component function names use PascalCase (e.g., `UserProfile`).
- Utility and hook files use kebab-case (e.g., `use-countdown.ts`, `utils.ts`).
- Use descriptive names for variables and functions. For example, `isUserAuthenticated`, not `checkAuth()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts when the implementation itself can be tested through the app or existing tests.

## Application Structure & Architecture
- Stick to existing directory structure - don't create new base folders without approval.
- Do not change the application's dependencies without approval.
- Follow the existing folder structure:
  - `src/app/` - Expo Router file-based routing
  - `src/components/` - Reusable components (ui, elements, inputs, wrappers)
  - `src/hooks/` - Custom React hooks
  - `src/lib/` - Utility functions and shared logic
  - `src/providers/` - Context providers
  - `src/types/` - TypeScript type definitions

## Development Workflow
- If the user doesn't see changes reflected in the app, they may need to run `bun run dev` or restart the Expo development server.
- Use `bun run lint` to check for TypeScript and ESLint errors.
- Use `bun run format` to format code with Prettier.
- Use `bun run shadcn` to add new React Native Reusables components.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.


=== typescript rules ===

## TypeScript
- Always use TypeScript for all new files.
- Use explicit type annotations for function parameters and return types.
- Use `type` for all type definitions (object shapes, unions, primitives).
- Use inline types when there's no reusability; only extract to named `type` when reused.
- Prefer arrow functions (`const`) over the `function` keyword.
- Use proper type imports: `import type { User } from '@/types'`.

<code-snippet name="Inline Types" lang="typescript">
export const Button = ({ title, onPress, disabled = false }: { title: string; onPress: () => void; disabled?: boolean; }) => {
    // component implementation
}
</code-snippet>

<code-snippet name="Extracted Types (when reused)" lang="typescript">
type ButtonProps = { title: string; onPress: () => void; disabled?: boolean; }

export const Button = (props: ButtonProps) => { /* ... */ }
export const IconButton = ({ icon, ...props }: { icon: string } & ButtonProps) => { /* ... */ }
</code-snippet>


=== react-native rules ===

## React Native Best Practices
- Always use functional components with hooks.
- Prefer Tailwind CSS classes; use inline styles when Tailwind is not possible (no `StyleSheet.create()`).
- Use the custom `Button` component from `@/components/ui/button` instead of `Pressable` or `TouchableOpacity`.
- Use `memo()` for components that render frequently with the same props.
- Use `useMemo()` and `useCallback()` appropriately to prevent unnecessary re-renders.
- Use `FlatList` or `FlashList` for long lists instead of `ScrollView` with `.map()`.
- Always respect safe area insets using `react-native-safe-area-context`.


=== expo rules ===

## Expo Router
- Use file-based routing in `src/app/`.
- Route files export a default component.
- Use `(tabs)` for tab-based navigation, `(auth)` for auth routes.
- Use `_layout.tsx` files for layouts.
- Use `useRouter()` hook for programmatic navigation.
- Use `<Link>` component for declarative navigation.

<code-snippet name="Layout Example" lang="typescript">
import { Stack } from 'expo-router';

const Layout = () => {
    return (
        <Stack screenOptions={{ headerShown: false }}>
            <Stack.Screen name="index" />
            <Stack.Screen name="settings" />
        </Stack>
    );
}

export default Layout;
</code-snippet>

## Expo APIs
- Leverage Expo's built-in APIs for device features.
- Use `expo-secure-store` for sensitive data, not `AsyncStorage`.
- Always handle permissions properly using Expo's permission APIs.


=== styling rules ===

## Tailwind CSS
- Use Tailwind utility classes via `uniwind`.
- Use `cn()` utility from `@/lib/utils` to merge class names.
- Use `class-variance-authority` (cva) for component variants.

<code-snippet name="Tailwind Example" lang="typescript">
import { cn } from '@/lib/utils';

export const Card = ({ className, children }: { className?: string; children: React.ReactNode }) => {
    return (
        <View className={cn('rounded-lg bg-white p-4 shadow-sm', className)}>
            {children}
        </View>
    );
}
</code-snippet>


=== component rules ===

## Component Architecture
- Organize components by type:
  - `ui/` - Base UI components
  - `elements/` - Composite elements
  - `inputs/` - Form input components
  - `wrappers/` - Layout wrapper components
- Check `src/components/ui/` for existing components before creating new ones.
- Use inline types for props when not reused.
- Provide sensible defaults for optional props.


=== hooks rules ===

## Custom Hooks
- Custom hooks must start with `use` prefix.
- Place in `src/hooks/` directory.
- Define TypeScript types for parameters and return values.

<code-snippet name="Hook Example" lang="typescript">
export const useCountdown = ({ initialSeconds, onComplete }: { initialSeconds: number; onComplete?: () => void }) => {
    const [seconds, setSeconds] = useState(initialSeconds);
    // hook implementation
    return { seconds };
}
</code-snippet>


=== state-management rules ===

## State Management
- Use `useState` for component-local state.
- Use `useReducer` for complex state logic.
- Use React Context API for global state (create providers in `src/providers/`).
- Use `expo-secure-store` for sensitive data (tokens, credentials).
- Use keys from `src/lib/keys.ts` for consistent storage keys.

<code-snippet name="Secure Storage" lang="typescript">
import * as SecureStore from 'expo-secure-store';
import { STORAGE_KEYS } from '@/lib/keys';

await SecureStore.setItemAsync(STORAGE_KEYS.AUTH_TOKEN, token);
const token = await SecureStore.getItemAsync(STORAGE_KEYS.AUTH_TOKEN);
await SecureStore.deleteItemAsync(STORAGE_KEYS.AUTH_TOKEN);
</code-snippet>


=== authentication rules ===

## Authentication & Security
- Follow existing auth patterns in `src/app/(auth)/`.
- Use secure storage for auth tokens.
- Validate user input on both client and server.
- Always use HTTPS for API requests.
- Include auth tokens in request headers.
- Handle API errors gracefully with user-friendly messages.


=== icons-and-assets rules ===

## Icons & Assets
- Use `lucide-react-native` for icons.
- Use the custom `Icon` component from `src/components/ui/icon.tsx` when available.
- Place static assets in `assets/` directory.
- Optimize assets before adding to project.

<code-snippet name="Icon Usage" lang="typescript">
import { Mail, Lock } from 'lucide-react-native';

<Mail size={24} color="#000" />
</code-snippet>


=== code-quality rules ===

## Code Quality
- Run `bun run lint` before finalizing changes.
- Run `bun run format` to format code.
- Prefer self-documenting code over comments.
- Add JSDoc comments for complex functions.
- Always handle errors gracefully with try-catch blocks.

<code-snippet name="Error Handling" lang="typescript">
const fetchUserData = async (userId: string): Promise<User | null> => {
    try {
        const response = await fetch(`/api/users/${userId}`);
        if (!response.ok) throw new Error('Failed to fetch user');
        return await response.json();
    } catch (error) {
        console.error('Error fetching user:', error);
        return null;
    }
}
</code-snippet>


=== accessibility rules ===

## Accessibility
- Add `accessibilityLabel` to interactive components.
- Use `accessibilityHint` for additional context.
- Set appropriate `accessibilityRole` values.
- Ensure proper color contrast.

<code-snippet name="Accessibility" lang="typescript">
<Pressable
    accessibilityRole="button"
    accessibilityLabel="Submit form"
    accessibilityHint="Double tap to submit"
    onPress={handleSubmit}
>
    <Text>Submit</Text>
</Pressable>
</code-snippet>


=== performance rules ===

## Performance Optimization
- Use `memo()` for expensive components with same props.
- Use `useCallback` and `useMemo` to prevent unnecessary re-renders.
- Use `FlatList` with proper `keyExtractor` for long lists.
- Clean up subscriptions, timers, and event listeners in `useEffect` cleanup.


=== api-integration rules ===

## API Integration
- Create centralized API client in `src/lib/`.
- Include auth tokens automatically in requests.
- Handle common errors (401, 403, 500) consistently.
- Always show loading indicators during API calls.
- Disable form submissions while requests are pending.


=== project-specific rules ===

## Project-Specific Guidelines
- Use theme provider from `src/providers/theme.tsx`.
- Support both light and dark modes.
- Use `class-variance-authority` for component variants.
- Place utility functions in `src/lib/utils.ts`.
- Reuse input components from `src/components/inputs/`.

</react-native-guidelines>
